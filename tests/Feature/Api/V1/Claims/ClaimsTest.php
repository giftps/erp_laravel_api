<?php

namespace Tests\Feature\Api\V1\Claims;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ClaimsTest extends TestCase
{
    protected $connection = 'testing';
    
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_getting_claims()
    {
        // Action
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ])->getJson(route('claims.index'));

        // Assertion
        $response->assertStatus(200);
        $this->assertEquals(count($response->json()), 1);
    }

    public function test_showing_single_claim(){
        // Action
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ])->getJson(route('claims.show', $this->claims->id));

        // Assertion
        $response->assertStatus(200);
        
        $this->assertEquals($response->json()['id'], $this->claims->id);
    }

    // Validating the preauthorisation id
    public function test_preauthorisation_id_validation_before_storing(){
        $this->withExceptionHandling();
        $this->whatToValidate('preauthorisation_id');
    }

    // Validating the claims logs id
    public function test_claims_logs_id_validation_before_storing(){
        $this->withExceptionHandling();
        $this->whatToValidate('claims_logs_id');
    }

    // Validating the member id
    public function test_member_id_validation_before_storing(){
        $this->withExceptionHandling();
        $this->whatToValidate('member_id');
    }

    // Validating auth number
    public function test_auth_number_validation_before_storing(){
        $this->withExceptionHandling();
        $this->whatToValidate('auth_number');
    }

    // Validating auth number
    public function test_invoice_number_validation_before_storing(){
        $this->withExceptionHandling();
        $this->whatToValidate('invoice_number');
    }

    // Validating line items
    public function test_line_items_validation_before_storing(){
        $this->withExceptionHandling();
        $this->whatToValidate('line_items');
    }

    /* 
        This method is what accepts the key value that is to be validated 
        when a post request is made 
    */
    private function whatToValidate($key){
        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ])->postJson(route('claims.store'))
                        ->assertUnprocessable();

        $response->assertJsonValidationErrors([$key]);
    }

    /**
     * Testing posting of data
     */
    public function test_storing_claims_data(){
        // Action
        $auth_number = (string)time(). 'au';
        $invoice_number = (string)time() . 'inv';
        $tariff_code = (string)time() . 'tar';
        $claim_code = (string)time() . 'clm';

        $store_line_items = [
            'tariff_code' => $tariff_code,
            'claim_code' => $claim_code,
            'diagnosis' => 'headache',
            'icd10' => 'z20',
            'amount' => 20,
            'date_of_service' => date('Y-m-d')
        ];

        $store_data = [
            'preauthorisation_id' => $this->preauthorisation->id,
            'claims_logs_id' => $this->claims_logs->id,
            'member_id' => $this->member->member_id,
            'auth_number' => $auth_number,
            'invoice_number' => $invoice_number,
            'line_items' => [$store_line_items]
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ])->postJson(route('claims.store'), $store_data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('claims', [
            'preauthorisation_id' => $this->preauthorisation->id,
            'claims_logs_id' => $this->claims_logs->id,
            'member_id' => $this->member->member_id,
            'auth_number' => $auth_number,
            'invoice_number' => $invoice_number,
        ]);

        $this->assertDatabaseHas('claim_line_items', $store_line_items);
    }

    /**
     * Testing updating of data
     */
    public function test_updating_claims_data(){
        // Action
        $auth_number = (string)time(). 'an';
        $invoice_number = (string)time() . 'in';
        $tariff_code = (string)time() . 'trf';
        $claim_code = (string)time() . 'cl';

        $store_line_items = [
            'tariff_code' => $tariff_code,
            'claim_code' => $claim_code,
            'diagnosis' => 'headache',
            'icd10' => 'z20',
            'amount' => 20,
            'date_of_service' => date('Y-m-d')
        ];

        $store_data = [
            'preauthorisation_id' => $this->preauthorisation->id,
            'claims_logs_id' => $this->claims_logs->id,
            'member_id' => $this->member->member_id,
            'auth_number' => $auth_number,
            'invoice_number' => $invoice_number,
            'line_items' => [$store_line_items]
        ];

        $response = $this->withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->access_token,
        ])->putJson(route('claims.update', $this->claims->id), $store_data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('claims', [
            'preauthorisation_id' => $this->preauthorisation->id,
            'claims_logs_id' => $this->claims_logs->id,
            'member_id' => $this->member->member_id,
            'auth_number' => $auth_number,
            'invoice_number' => $invoice_number,
        ]);

        $this->assertDatabaseHas('claim_line_items', $store_line_items);
    }
}
