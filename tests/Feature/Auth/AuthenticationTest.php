<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_has_created_a_personal_access_client()
    {
        $this->assertEquals(count(DB::table('oauth_clients')->where('personal_access_client', '=', 1)->get()),1);
    }

    public function test_users_can_authenticate_using_the_login_screen()
    {
        
        $response = $this->postJson(route('user.login'), [
            'email' => $this->user->email, //This user is created in the parent class ie TestCase class
            'password' => 'password',
            'is_otp' => 0
        ])->json();

        $this->assertAuthenticated();
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $response = $this->post(route('user.login'), [
            'email' => $this->user->email, //This user is created in the parent class ie TestCase class
            'password' => 'wrong-password',
            'is_otp' => 0
        ]);

        $response->assertStatus(401);
    }
}
