<?php

namespace App\Http\Controllers\Api\V1\HealthProcessings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Api\V1\HealthProcessings\Tariff;
use App\Http\Resources\Api\V1\HealthProcessings\TariffsResource;
use App\Imports\TariffsImport;
use App\Jobs\TariffsImportJob;
use Illuminate\Support\Facades\Cache;
use App\Models\ImportProgress;
use Illuminate\Http\UploadedFile;
use PhpOffice\PhpSpreadsheet\IOFactory;
use App\Http\Resources\ImportProgressResource;

class TariffsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tariffs = Tariff::paginate(25);
        return response()->json(TariffsResource::collection($tariffs));
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
            'discipline_id' => 'required|integer',
            'claim_code_id' => 'nullable|sometimes|integer',
            'code' => 'required|string',
            'description' => 'required|string',
            'ses_rate' => 'nullable|sometimes|numeric',
            'effective_date' => 'required|date'
        ]);

        $tariff = new Tariff;
        $tariff->discipline_id = $request->discipline_id;
        $tariff->claim_code_id = $request->claim_code_id;
        $tariff->code = $request->code;
        $tariff->description = $request->description;
        $tariff->ses_rate = $request->ses_rate;
        $tariff->effective_date = $request->effective_date;

        $tariff->save();

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
        $tariff = Tariff::find($id);

        if($tariff){
            return response()->json(new TariffsResource($tariff));
        }else{
            return response()->json(['error' => 'data with requested id not found'], 404);
        }
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
            'discipline_id' => 'required|integer',
            'claim_code_id' => 'nullable|sometimes|integer',
            'code' => 'required|string',
            'description' => 'required|string',
            'ses_rate' => 'nullable|sometime|numeric',
            'effective_date' => 'required|date'
        ]);

        $tariff = Tariff::find($id);
        $tariff->discipline_id = $request->discipline_id;
        $tariff->claim_code_id = $request->claim_code_id;
        $tariff->code = $request->code;
        $tariff->description = $request->description;
        $tariff->ses_rate = $request->ses_rate;
        $tariff->effective_date = $request->effective_date;

        $tariff->save();

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
        //
    }
    
    /**
     * Importing tariffs
     */
    public function importTariffs(Request $request){
        $this->validate($request, [
            'excel' => 'required|mimes:xlsx,csv,xls'
        ]);

        $file = $request->file('excel');

        /* 
            This is a helper function for initialising 
            the progress of the import
        */
        saveProgress($file, 'tariffs');
        
        Excel::import(new TariffsImport, $request->file('excel'));

        return response()->json([
            'msg' => 'Import queued successfully!'
        ], 200);
    }

    public function tariffsImportProgress(){
        // This is a helper function that shows the progress of the import
        return importProgress('tariffs');
    }
}
