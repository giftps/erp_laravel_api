<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

use App\Models\Api\V1\Lookups\MedicalHistoryOption;

use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Membership\Member;
use Illuminate\Support\Facades\Redis;

use PDF;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

Route::get('/renewal-quotation', [QuotationsController::class, 'renewalQuotation']);
Route::get('/new-member-quotation', [QuotationsController::class, 'newMemberQuotation']);

Route::get('/email-template', function(){
    return view('emails.user-registration');
});

Route::get('/test-api', function(){
    return response()->json(['msg' => 'test api']);
});

Route::get('/notifications-layout', function(){
    return view('notifications.broker-registration');
});

Route::get('/gop-test', function(){
    $data = [
        'imagePath'    => public_path('img/profile.png'),
        'name'         => 'John Doe',
        'address'      => 'USA',
        'mobileNumber' => '000000000',
        'email'        => 'john.doe@email.com',
        'is_international' => true
    ];
    $pdf = PDF::loadView('documents.guarantee-of-payment', $data);

    // Saving to starage;
    // Storage::put('public/pdf/quotation.pdf', $pdf->output());

    return $pdf->stream('gop.pdf');
});

Route::get('/pdf-test', function(){

    
    $medical_history_options = MedicalHistoryOption::all();
    $family = Family::find(1);
    $principal = Member::where('family_id', '=', $family->id)->where('dependent_code', '=', '00')->first();
    $family_members = Member::with(['medicalHistory'])->where('family_id', '=', $family->id)->get();
    
    $data = [
        'family' => $family,
        'principal' => $principal,
        'family_members' => $family_members,
        'medical_history_options' => $medical_history_options,
        'is_new_application' => false
    ];
    // return view('documents.membership-form', $data);
    $pdf = PDF::loadView('documents.membership-form', $data);

    // Saving to starage;
    // Storage::put('public/pdf/quotation.pdf', $pdf->output());

    return $pdf->stream('gop.pdf');
});

Route::get('/redis-test', function(){
    Redis::set('test', 'I am redis');

    return Redis::get('test');
});

require __DIR__.'/auth.php';


//? Form previews
Route::get('/forms/quotation', function(){
    $members = Member::where('member_id', '>', 0)->get();

    // dd($members);
    $pdf = PDF::loadView('documents.new-member-quotation');
    return $pdf->stream('gop.pdf');
});
