<?php

namespace App\Http\Controllers\Api\V1\Claims;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Api\V1\Claims\ClaimsLog;
use App\Http\Resources\Api\V1\Claims\ClaimsLogsResource;

use App\Models\Api\V1\HealthProcessings\ServiceProvider;

use App\Models\Api\V1\UserAccess\Role;

use Carbon\Carbon;

class ClaimsLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = ClaimsLog::where('id', '>', 0);

        $claims_logs = $this->filteredResults($logs);

        return response()->json(ClaimsLogsResource::collection($claims_logs));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "service_provider_id" => "required|integer",
            "date_received" => "required|date",
            "statement_month" => "required|string",
            "statement_total" => "required|numeric",
            "number_of_invoices" => "required|integer",
            "receiver_id" => "required|integer",
            "status" => "required|string"
        ]);

        // Calling a method that generates the batch number and storing the batch number in a variable
        $batch_number = $this->generateBatchNumber();

        $role = Role::where('name', '=', 'Assessor')->first();

        if(count($role->users) === 0){
            return response()->json(['error' => 'no assessor found on the system, please add user with the role of "assessor" assessor before proceeding'], 404);
        }

        $service_provider = ServiceProvider::find($request->service_provider_id);

        // Storing the claims log
        $claims_log = new ClaimsLog;
        $claims_log->batch_number = $batch_number;
        $claims_log->service_provider_id = $request->service_provider_id;
        $claims_log->date_received = $request->date_received;
        $claims_log->due_date = Carbon::parse($request->date_received)->addDays($service_provider->payment_term_days);
        $claims_log->statement_month = $request->statement_month;
        $claims_log->statement_total = $request->statement_total;
        $claims_log->number_of_invoices = $request->number_of_invoices;
        $claims_log->receiver_id = $request->receiver_id;
        $claims_log->status = $request->status;
        $claims_log->save();

        return response()->json(['msg' => 'saved successfully!'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $claims_log = ClaimsLog::find($id);

        return response()->json(new ClaimsLogsResource($claims_log));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "service_provider_id" => "required|integer",
            "date_received" => "required|date",
            "statement_month" => "required|string",
            "statement_total" => "required|numeric",
            "number_of_invoices" => "required|integer",
            "receiver_id" => "required|integer",
            "status" => "required|string"
        ]);

        $service_provider = ServiceProvider::find($request->service_provider_id);

        // Storing the claims log
        $claims_log = ClaimsLog::find($id);
        $claims_log->service_provider_id = $request->service_provider_id;
        $claims_log->date_received = $request->date_received;
        $claims_log->due_date = Carbon::parse($request->date_received)->addDays($service_provider->payment_term_days);
        $claims_log->statement_month = $request->statement_month;
        $claims_log->statement_total = $request->statement_total;
        $claims_log->number_of_invoices = $request->number_of_invoices;
        $claims_log->receiver_id = $request->receiver_id;
        $claims_log->status = $request->status;
        $claims_log->save();

        return response()->json(['msg' => 'updated successfully!'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $claims_log = ClaimsLog::find($id);

        if($claims_log){
            $claims_log->delete();

            return response()->json(['msg' => 'deleted successfully'], 200);
        }

        return response()->json(['error' => 'failed to delete'], 422);
    }

    private function generateBatchNumber(){
        $claims_log = ClaimsLog::all()->last();
        $number = 1;

        $nextId = ($claims_log === null ? 0 : $claims_log->id) + 1;

        $suffix = str_pad($nextId, 5, '0', STR_PAD_LEFT);

        $batch_number = 'BCH' . $suffix;

        return $batch_number;
    }

    private function filteredResults($logs){
        // Filtering by received date range
        if(isset($_GET['date_received_from']) && $_GET['date_received_from'] != ''){
            $date_received_from = $_GET['date_received_from'];
            $logs->where('date_received', '>=', $date_received_from);
        }

        if(isset($_GET['date_received_to']) && $_GET['date_received_to'] != ''){
            $date_received_to = $_GET['date_received_to'];
            $logs->where('date_received', '<=', $date_received_to);
        }

        // Filtering by due date range
        if(isset($_GET['due_date_from']) && $_GET['due_date_from'] != ''){
            $due_date_from = $_GET['due_date_from'];
            $logs->where('due_date', '>=', $due_date_from);
        }

        if(isset($_GET['due_date_to']) && $_GET['due_date_to'] != ''){
            $due_date_to = $_GET['due_date_to'];
            $logs->where('due_date', '<=', $due_date_to);
        }

        $claims_logs = $logs->limit(25)->orderBy('created_at', 'DESC')->get();

        return $claims_logs;
    }

    public function assessorBatches(){
        $claims_logs = ClaimsLog::get();
        return response()->json(ClaimsLogsResource::collection($claims_logs));
    }
}
