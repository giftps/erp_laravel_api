<?php

namespace App\Http\Controllers\Api\V1\Membership;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\GroupsImports;
use App\Models\Api\V1\Membership\Group;
use App\Http\Resources\Api\V1\Membership\GroupsResource;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(isset($_GET['group_type'])){
            $group_type = $_GET['group_type'];
            $groups = Group::where('group_type', '=', $group_type);

            if (isset($_GET['search']) && $_GET['search'] != ''){
                $search = $_GET['search'];
                $groups->where('group_name', 'LIKE', $search . '%')->orWhere('code', 'LIKE', $search . '%');
            }

            $grps = $groups->get();
            return response()->json(GroupsResource::collection($grps));
        }else{
            return response()->json(['error' => 'group type not specified', 'status' => 422], 422);
        }
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
            'code' => 'required|string',
            'office_number' => $request->group_type == 'corporate' ? 'required|string' : '',
            'group_name' => 'required|string',
            'website' => $request->group_type == 'corporate' ? 'required|string' : '',
            'nuit' => $request->group_type == 'corporate' ? 'required|string' : '',
            'industry' => $request->group_type == 'corporate' ? 'required|string' : '',
            'group_size' => $request->group_type == 'corporate' ? 'required|string' : '',
            'join_date' => $request->group_type == 'corporate' ? 'required|date' : '',
            'group_type' => $request->group_type == 'corporate' ? 'required|string' : '',
            'contact_person_name' => $request->group_type == 'corporate' ? 'nullable|sometimes|string' : '',
            'contact_email' => $request->group_type == 'corporate' ? 'nullable|sometimes|email' : '',
            'contact_phone_number' => $request->group_type == 'corporate' ? 'nullable|sometimes|string' : ''
        ]);

        $groups = new Group;
        $groups->group_name = $request->group_name;
        $groups->code = $request->code;
        $groups->office_number = $request->office_number;
        $groups->nuit = $request->nuit;
        $groups->industry = $request->industry;
        $groups->website = $request->website;
        $groups->group_size = $request->group_size;
        $groups->join_date = $request->join_date;
        $groups->contact_person_name = $request->contact_person_name;
        $groups->contact_email = $request->contact_email;
        $groups->contact_phone_number = $request->contact_phone_number;
        $groups->group_type = $request->group_type;
        $groups->status = $request->status;
        $groups->save();

        return response()->json(['msg' => 'saved successfully!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $group = Group::find($id);

        return response()->json(new GroupsResource($group));
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
            'code' => 'required|string',
            'office_number' => 'required|string',
            'group_name' => 'required|string',
            'website' => 'required|string',
            'nuit' => 'required|string',
            'industry' => 'required|string',
            'group_size' => 'required|string',
            'join_date' => 'required|date',
            'group_type' => 'required|string',
            'contact_person_name' => 'nullable|sometimes|string',
            'contact_email' => 'nullable|sometimes|email',
            'contact_phone_number' => 'nullable|sometimes|string'
        ]);

        $groups = Group::find($id);
        $groups->group_name = $request->group_name;
        $groups->code = $request->code;
        $groups->office_number = $request->office_number;
        $groups->nuit = $request->nuit;
        $groups->industry = $request->industry;
        $groups->website = $request->website;
        $groups->group_size = $request->group_size;
        $groups->join_date = $request->join_date;
        $groups->contact_person_name = $request->contact_person_name;
        $groups->contact_email = $request->contact_email;
        $groups->contact_phone_number = $request->contact_phone_number;
        $groups->group_type = $request->group_type;
        $groups->status = $request->status;
        $groups->save();

        return response()->json(['msg' => 'updated successfully!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Group::find($id)->delete();

        return response()->json(['msg' => 'deleted successfully!']);
    }

    public function importGroups(Request $request){
        Excel::import(new GroupsImports, $request->file('excel'));

        return response()->json(['msg' => 'imported successfully!', 'status' => 200], 200);
    }
}
