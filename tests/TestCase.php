<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

use Illuminate\Support\Facades\DB;

use Laravel\Passport\HasApiTokens;

use Laravel\Passport\Passport;

use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Models\Api\V1\Lookups\AuthType;
use App\Models\Api\V1\Lookups\BrokerType;
use App\Models\Api\V1\Lookups\Currency;
use App\Models\Api\V1\Lookups\GroupType;
use App\Models\Api\V1\Lookups\SchemeOption;
use App\Models\Api\V1\Lookups\SchemeType;
use App\Models\Api\V1\Lookups\SubscriptionPeriod;

use App\Models\Api\V1\Sales\Broker;
use App\Models\Api\V1\Sales\BrokerHouse;

use App\Models\Api\V1\Membership\Group;
use App\Models\Api\V1\Membership\Family;
use App\Models\Api\V1\Membership\Member;

use App\Models\Api\V1\HealthProcessings\Discipline;
use App\Models\Api\V1\HealthProcessings\ServiceProvider;

use App\Models\Api\V1\Preauthorisations\CaseNumber;
use App\Models\Api\V1\Preauthorisations\Preauthorisation;

use App\Models\Api\V1\Claims\ClaimsLog;
use App\Models\Api\V1\Claims\Claim;
use App\Models\Api\V1\Claims\ClaimLineItem;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase, CreatesApplication;

    public $access_token = '';
    public $user;
    public $claims;
    public $claims_logs;
    public $member;
    public $preauthorisation;

    public function setUp() : void{
        parent::setUp();

        $this->withoutExceptionHandling();   

        $this->user = User::factory()->create();

        Passport::$hashesClientSecrets = false;

        // Running a php artisan passport:install
        $this->artisan(
            'passport:install'
        )->assertSuccessful();
        
        $this->authenticate();
        
    }

    private function authenticate(){
        $response = $this->postJson(route('user.login'), [
            'email' => $this->user->email,
            'password' => 'password',
            'is_otp' => 0
        ])->json();

        $this->access_token = $response['access_token'];

        $this->initialDatabasePopulating();
    }

    /**
     * All the factories that will put initial data
     * in the database will be in the method below
     */
    private function initialDatabasePopulating(){
        $auth_type = AuthType::factory()->create();
        $broker_type = BrokerType::factory()->create();
        $payCurrency = Currency::factory()->create();
        $group = Group::factory()->create();
        $group_type = GroupType::factory()->create();
        $scheme_option = SchemeOption::factory()->create();
        $scheme_type = SchemeType::factory()->create();
        $subscription_period = SubscriptionPeriod::factory()->create();

        $broker_house = BrokerHouse::factory()->create();
        $broker = Broker::factory()->for($broker_house)->create();

        $family = Family::factory()->for($group)->for($subscription_period)->for($broker)->for($group_type)->create();
        $this->member = Member::factory()->for($family)->for($scheme_option)->for($scheme_type)->create();
        

        $discipline = Discipline::factory()->create();
        $service_provider = ServiceProvider::factory()->for($discipline)->create();

        $case_number = CaseNumber::factory()->for($this->member)->for($service_provider)->create();
        $this->preauthorisation = Preauthorisation::factory()->for($this->member)->for($case_number)->for($service_provider)->for($auth_type)->create();

        $this->claims_logs = ClaimsLog::factory()->for($service_provider)->create();
        $this->claims = Claim::factory()->for($this->claims_logs)->for($this->preauthorisation)->for($this->member)->create();
        $claim_line_items = ClaimLineItem::factory()->count(3)->for($this->claims)->create();
    }
}
