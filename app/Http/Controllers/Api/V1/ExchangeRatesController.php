<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\V1\ExchangeRate;
use Carbon\Carbon;
use App\Http\Resources\Api\V1\ExchangeRatesResource;

class ExchangeRatesController extends Controller
{
    public function currentExchangeRate(){
        if (!isset($_GET['from'])){
            return response()->json(['error' => 'from currency not specified'], 422);
        }

        if (!isset($_GET['to'])){
            return response()->json(['error' => 'to currency not specified'], 422);
        }

        // if (!isset($_GET['amount'])){
        //     return response()->json(['error' => 'to currency not specified'], 422);
        // }

        $from = $_GET['from'];
        $to = $_GET['to'];
        // $amount = $_GET['amount'];

        return response()->json(exchangeRate($from, $to));
    }

    public function getHistoricExchangeRate(){
        $three_months_ago = explode(" ", (string)Carbon::now()->subMonths(3))[0];
        $today = date('Y-m-d');

        $exchange_rates = ExchangeRate::whereBetween('date', [$three_months_ago, $today])->get();

        return response()->json(ExchangeRatesResource::collection($exchange_rates));
    }
}
