<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\HealthProcessings\Tariff;

use App\Models\Api\V1\Membership\Member;
use App\Models\Api\V1\HealthProcessings\ServiceProvider;

use App\Models\Api\V1\HealthProcessings\ServiceProviderPriceList;
use App\Http\Resources\Api\V1\HealthProcessings\ServiceProviderPriceListsResource;

class SearchesController extends Controller
{
    public function members($search){
        $members = Member::where('member_number', 'LIKE', '%' . $search . '%')
                ->orWhere('first_name', 'LIKE', $search . '%')
                ->orWhere('email', 'LIKE', '%' . $search . '%')
                ->orWhere('nrc_or_passport_no', 'LIKE', '%' . $search . '%')
                ->orWhere('work_number', 'LIKE', '%' . $search . '%')
                ->orWhere('mobile_number', 'LIKE', '%' . $search . '%')->get(['member_id', 'member_number', 'first_name', 'last_name', 'email', 'work_number', 'mobile_number', 'nrc_or_passport_no']);
        return $members;
    }

    public function serviceProviders($search){
        return ServiceProvider::where('practice_number', 'LIKE', '%' . $search . '%')->orWhere('name', 'LIKE', '%' . $search . '%')->get(['service_provider_id', 'practice_number', 'name']);
    }

    /**
     * The method below gets services from the service providers pricelists table
     * The pricelists table lists the prices of services that a facility offers
     */
    public function providerServices(){
        $service_provider_id = null;
        $search_value = null;

        $tariff_ids = [];

        // Getting the service provider id pased in the query string otherwise throwing an error.
        if(isset($_GET['service_provider_id']) && $_GET['service_provider_id'] !== ''){
            $service_provider_id = $_GET['service_provider_id'];
        }else{
            return response()->json(['error' => 'please provide the service_provider_id'], 422);
        }

        // Getting the search value pased in the query string otherwise throwing an error.
        if(isset($_GET['search_value']) && $_GET['search_value'] !== ''){
            $search_value = $_GET['search_value'];

            // Checking if the search value matches any tariff code
            $tariff_ids = Tariff::where('code', '=', $search_value)->pluck('id');
        }

        $services = null;
        if(count($tariff_ids) > 0){
            $services = ServiceProviderPriceList::where('service_provider_id', '=', $service_provider_id)->whereIn('tariff_id', $tariff_ids)->get(['id', 'tariff_id', 'description']);
        }else{
            if($search_value){
                $services = ServiceProviderPriceList::where('service_provider_id', '=', $service_provider_id)->where('description', 'LIKE', '%' . $search_value . '%')->get(['id', 'tariff_id', 'description']);
            }else{
                $services = ServiceProviderPriceList::where('service_provider_id', '=', $service_provider_id)->get(['id', 'tariff_id', 'description']);
            }
        }
        
        return response()->json($services);
    }
}
