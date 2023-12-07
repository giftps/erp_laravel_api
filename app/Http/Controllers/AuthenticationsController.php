<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail; 
use App\Mail\UserRegistrationEmail;
use App\Http\Resources\UsersResource;
use App\Models\Employee;
use App\Models\Api\V1\Sales\Broker;
use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\ServiceProviders\ServiceProvider;
use App\Models\Api\V1\UserAccess\Role;
use App\Models\OtpVerification;
use App\Notifications\LoginOtp;
use App\Notifications\BrokerBrokerHousePasswordReset;
use Illuminate\Support\Str;
use App\Notifications\BirthdayWishes;
use Illuminate\Support\Facades\DB;

class AuthenticationsController extends Controller
{
    public function login(Request $request){
        $this->validate($request, [
            'email' => $request->is_otp == 0 ? 'required|email' : '',
            'phone_number' => $request->is_otp == 1 ? 'required|string' : '',
            'is_otp' => 'required|boolean',
            'otp' => $request->is_otp == 1 ? 'required|numeric' : '',
            'password' => $request->is_otp == 0 ? 'required|string' : ''
        ]);

        // These credentials are passed if login is not via otp
        $login_credentials=[
            'email'=>$request->email,
            'password'=>$request->password,
        ];

        $check_user = User::where('email', '=', $request->email)->first();

        // Login with otp
        $user = User::where('phone_number', '=', $request->phone_number)->first();
        if ($user){
            return $this->phoneNumberAndOtpLogin($user, $request);
        }
        
        // Login with email and password
        if(isset($check_user)){
            return $this->passedLoginData($login_credentials, $request);
        }else{
            return response()->json(['message' => 'Invalid login credentials!', 'status' => 401], 401);
        }
    }

    public function register(Request $request){
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['required', 'string'],
            'register_as' => 'required|string',
            'password' => ['required', Rules\Password::defaults()],
        ]);

        // Calling the method that will search the table based on the registration type selected
        // to check if the use trying to register is in the system.
        if($this->registerAs($request->register_as, $request->email) === false){
            return response()->json(['msg' => 'Not Found', 'status' => 404], 404);
        }

        // Generating the unique user id
        $user_id = User::all()->last();
        $nextId = ($user_id === null ? 0 : $user_id->user_id) + 1;

        $suffix = str_pad($nextId, 3, '0', STR_PAD_LEFT);

        $unique_id = $suffix;

        // Calling the method that will return the id of the role that was selected.
        $role_id = 0;
        if($this->roleId($request->register_as) > 0){
            $role_id = $this->roleId($request->register_as);
        }else{
            return response()->json(['msg' => 'The selected role doesn\'t exist!', 'status' => 404], 404);
        }

        // Saving the user
        $user = User::create([
            'unique_id' => $unique_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'role_id' => $role_id,
            'phone_number' => $request->phone_number,
            'user_type' => $request->user_type,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        $confirmation_code = rand(100000, 999999);

        $user->confirmation_code = $confirmation_code;
        $user->save();

        Mail::to($request->email)->send(new UserRegistrationEmail($confirmation_code, 'registration'));

        $access_token = $user->createToken($request->email)->accessToken;

        return response()->json([
                'msg' => 'confirmation code sent', 
                'role' => $user->role->name,
                'access_token' => $access_token,
                'status' => 200
            ], 200
        );

        return response()->json(['msg' => 'code sent']);
    }

    public function verifyEmail(Request $request){
        $this->validate($request, [
            'confirmation_code' => 'required|string'
        ]);

        $user = User::where('email', '=', auth('api')->user()->email)->first();

        if($user->confirmation_code == $request->confirmation_code){
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->save();
            return response()->json(['msg' => 'verified', 'status' => 200], 200);
        }else{
            return response()->json(['msg' => 'wrong code!']);
        }
    }

    public function logout(){
        if (auth('api')->user()->id){
            DB::table('oauth_access_tokens')->where('user_id', '=', auth('api')->user()->id)->delete();
            return response()->json(['message' => 'logged out']);
        }else{
            return response()->json(['message' => 'Already Logged Out']);
        }
    }
    
    private function passedLoginData($login_credentials, $request){

        $user = User::where('email', '=', $login_credentials['email'])->first();

        if($user->failed_login_count == 3 && date('Y-m-d H:i:s') < $user->can_login_after){
            return response()->json(['error' => 'Too many login requests. Your account will be available 15 minutes after lockout.' , 'status' => 422], 422);
        }

        if(auth()->attempt($login_credentials)){
            $user->failed_login_count = 0;
            $user->can_login_after = null;
            $user->save();

            //generate the token for the user
            $access_token = auth()->user()->createToken($request->email)->accessToken;
            //now return this token on success login attempt
            $user = new UsersResource(auth()->user());
            return response()->json([
                'role' => $user->role->name, 
                'access_token' => $access_token, 'status' => 200], 200
            );
        }
        else{
            // Recording the number of failed login attempts and locking the user if they are 3.
            $this->wrongLoginCountAndBlock($request->email);

            //wrong login credentials, return, user not authorised to our system, return error code 401
            return response()->json(['error' => 'Unauthorised', 'status' => 401], 401);
        }
    }

    private function phoneNumberAndOtpLogin($user, $request){
        if($user->otp->code === $request->otp){
            if(date('Y-m-d H:i:s') < $user->otp->expires_at){
                //generate the token for the user
                $access_token = $user->createToken($user->email)->accessToken;
                //now return this token on success login attempt
                $user = new UsersResource(auth()->user());
                return response()->json([
                    // 'user' => $user, 
                    'access_token' => $access_token, 'status' => 200], 200
                );
            }else{
                return response()->json(['msg' => 'otp expired', 'status' => 401], 401);
            }
        }else{
            return response()->json(['msg' => 'wrong otp', 'status' => 401], 401);
        }
    }

    public function forgotPassword(Request $request){
        $this->validate($request, [
            'email' => 'required|email'
        ]);

        $user = User::where('email', '=', $request->email)->first();

        $token = bin2hex(random_bytes(40));

        if (!$user){
            // Returning the response
            return response()->json(['msg' => 'email not found'], 404);
        }else{
            // Saving the token which will be used for checking on the frontend.
            $user->token = $token;
            $user->save();

            $code = rand(100000, 999999);
            $user->password_reset_code = $code;
            $user->save();

            Mail::to($request->email)->send(new UserRegistrationEmail($code, 'password reset'));

            return response()->json(['msg' => 'code sent', 'token' => $token, 'status' => 200]);
        }
    }

    public function forgotPasswordReset(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
            'password_reset_code' => 'required'
        ]);

        $user = User::where('email', '=', $request->email)->where('password_reset_code', '=', $request->password_reset_code)->first();

        if (!$user){
            return response()->json(['msg' => 'wrong code'], 401); 
        }else{

            $user->password_reset_code = $request->password_reset_code;
            $user->password = Hash::make($request->password);
            $user->token = '';
            $user->save();

            return response()->json(['msg' => 'password reset'], 200);
        }
    }

    // Checking if the user trying to register exists in the relevant table
    private function registerAs($register_as, $email){
        switch($register_as){
            case 'employee':

                // Checking if the employee trying to register exists
                $employee = Employee::where('email', '=', $email)->first();
                if($employee){
                    return true;
                }else{
                    return false;
                }
                break;

            case 'broker':

                // Checking if the broker trying to register exists
                $broker = Broker::where('email_address', '=', $email)->first();
                if($broker){
                    return true;
                }else{
                    return false;
                }
                break;

            case 'healthcare':

                // Checking if the health care provider aka service provider email exists
                $service_provider = ServiceProvider::where('contact_email', '=', $email)->first();
                if($service_provider){
                    return true;
                }else{
                    return false;
                }
                break;

            default:
        }
    }

    public function checkToken($token){
        $token = User::where('token', '=', $token)->first();
        
        if ($token){
            return response()->json(['msg' => 'token found', 'status' => 200], 200);
        }else{
            return response()->json(['msg' => 'not found', 'status' => 404], 404);
        }
    }

    // Getting the role id of the role that was selected at registration
    private function roleId($register_as){
        $role = '';
        switch($register_as){
            case 'employee':
                $role = 'Employee';
                break;
            case 'member':
                $role = 'Member';
                break;
            case 'broker':
                $role = 'Broker';
                break;
            case 'healthcare':
                $role = 'Health Care Provider';
                break;
            default;
        }

        $role_id = Role::where('name', '=', $role)->first()->role_id;

        if($role_id){
            return $role_id;
        }

        return 0;
    }

    public function generateOtp(Request $request){
        $user = User::where('phone_number', '=', $request->phone_number)->first();

        // Checking if the user who has that phone number exists.
        if($user){
            $otp = rand(100000, 999999);

            // Deleting all the previous otps
            OtpVerification::where('user_id', '=', $user->user_id)->delete();

            // Saving the otp in the otp_verifications table
            $save_otp = new OtpVerification;
            $save_otp->user_id = $user->user_id;
            $save_otp->code = $otp;
            $save_otp->expires_at = Carbon::now()->addMinutes(10);
            $save_otp->save();

            // Sending the created otp to the user
            sendAText(str_replace("+", "", $request->phone_number), "Your otp is: $otp");

            return response()->json(['msg' => 'otp sent', 'status' => 200], 200);
        }else{
            return response()->json(['msg' => 'Phone number not found!', 'status' => 404], 404);
        }
    }

    public function memberLogin(Request $request){
        $login_credentials=[
            'member_number'=>$request->value,
            'login_otp' => $request->login_otp,
            'password' => $request->login_otp
            // 'password'=>$request->password,
        ];

        return response()->json(["response" => auth('member')->user()]);

        if(auth('member')->attempt($login_credentials)){
            //generate the token for the user
            $access_token = auth('member')->user()->createToken($request->value)->accessToken;

            //now return this token on success login attempt
            return response()->json([
                // 'user' => $user, 
                'access_token' => $access_token, 'status' => 200], 200
            );
        }else{
            return response()->json(['msg' => 'Authentication failed', 'status' => '401'], 401);
        }
    }

    public function memberLoginOtp(Request $request){
        $member = Member::where('member_number', '=', $request->value)->first();

        if(!$member){
            $member = Member::where('email', '=', $request->value)->first();
        }

        if(!$member){
            $member = Member::where('mobile_number', '=', $request->value)->first();
        }

        if (!$member){
            return response()->json(['error' => 'Member#, email or phone # not found'], 404);
        }

        $login_otp = rand(100000, 999999);

        $member->login_otp = $login_otp;
        $member->password = Hash::make($login_otp);
        $member->save();

        sendAText($member->mobile_number, "Dear member, login otp is: $login_otp");

        return response()->json(['msg' => 'Login OTP Sent', 'otp' => $login_otp,  'status' => 200], 200);
    }

    public function brokerBrokerHousePasswordReset(Request $request){
        $this->validate($request, [
            'email' => 'required|email',
        ]);

        $user = User::where('email', '=', $request->email)->first();

        // Checking if the user email exists
        if(!$user){
            return response()->json(['error' => 'user not found', 'status' => 404], 404);
        }

        $generated_password = Str::random(8);

        // Saving the generated password
        $user->password = Hash::make($generated_password);
        $user->save();

        // Sending a notification of the new login details
        $user->notify(new BrokerBrokerHousePasswordReset($user, $generated_password));

        return response()->json(['msg' => 'resent', 'status' => 200], 200);
    }

    private function wrongLoginCountAndBlock($value){
        $user = User::where('email', '=', $value)->orWhere('phone_number', '=', $value)->first();

        if($user){
            if($user->failed_login_count < 3){
                $user->failed_login_count = $user->failed_login_count + 1;
                $user->save();
            }

            $next_count = $user->failed_login_count + 1;
            if($next_count == 3){
                $user->failed_login_count = 3;
                $user->can_login_after = Carbon::now()->addMinutes(15);
                $user->save();

                return response()->json(['error' => 'Too many login requests. Your account will be available 15 minutes after lockout.', 'status' => 422], 422);
            }
        }
    }

    public function authCheck(){
        if(auth()->user()){
            return response()->json(['message' => "Authenticated"]);
        }
    }
}