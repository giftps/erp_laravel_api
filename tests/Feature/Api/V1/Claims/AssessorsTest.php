<?php

namespace Tests\Feature\Api\V1\Claims;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Api\V1\UserAccess\Role;
use Tests\TestCase;
use App\Models\User;

class AssessorsTest extends TestCase
{
    protected $connection = 'testing';
    
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    private $assessor;

    public function setUp() : void{
        parent::setUp();

        $this->assessor = User::create([
            'role_id' => Role::where('name', '=', 'Assessor')->first()?->role_id,
            'unique_id' => '123',
            'first_name' => 'Enock',
            'last_name' => 'Soko',
            'email' => 'enock@assessor.com',
            'phone_number' => '09849584345',
            'password' => Hash::make('12334343')
        ]);
    }

    public function test_get_all_claims_assessors()
    {
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ])->getJson(route('assessors.index'));

        // Assertion
        $response->assertStatus(200);
        $this->assertEquals(count($response->json()), 1);
    }

    // Validating Assessors that are to be stored
    public function test_first_name_validation_before_storing(){
        $this->withExceptionHandling();
        $this->whatToValidate('first_name');
    }

    public function test_last_name_validation_before_storing(){
        $this->withExceptionHandling();
        $this->whatToValidate('last_name');
    }

    public function test_email_validation_before_storing(){
        $this->withExceptionHandling();
        $this->whatToValidate('email');
    }

    public function test_phone_number_validation_before_storing(){
        $this->withExceptionHandling();
        $this->whatToValidate('phone_number');
    }

    /* 
        This method is what accepts the key value that is to be validated 
        when a post request is made 
    */
    private function whatToValidate($key){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ])->postJson(route('assessors.store'))
                        ->assertUnprocessable();

        $response->assertJsonValidationErrors([$key]);
    }

    public function test_storing_assessor(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ])->postJson(route('assessors.store'), [
            'first_name' => 'Sam',
            'last_name' => 'Soko',
            'email' => 'enock@assessor1.com',
            'phone_number' => '098495843451',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'first_name' => 'Sam',
            'last_name' => 'Soko',
            'email' => 'enock@assessor1.com',
            'phone_number' => '098495843451',
        ]);
    }

    public function test_updating_assessor(){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ])->putJson(route('assessors.update', $this->assessor->user_id), [
            'first_name' => 'Sam1',
            'last_name' => 'Soko1',
            'email' => 'enock@assessor1.com',
            'phone_number' => '098495843451',
        ]);

        $response->assertStatus(200);

        $this->assertDatabaseHas('users', [
            'first_name' => 'Sam1',
            'last_name' => 'Soko1',
            'email' => 'enock@assessor1.com',
            'phone_number' => '098495843451',
        ]);
    }
}
