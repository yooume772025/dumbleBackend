<?php

namespace App\Http\Controllers;

use App\Models\Location;
use DB;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    public function location()
    {
        return view('master.location');
    }

    public function hometowns()
    {
        $Location = DB::table('hometowns')->get();

        return response()->json(['success' => true, 'data' => $Location], 200);
    }

    public function years()
    {
        $Location = DB::table('years')->get();

        return response()->json(['success' => true, 'data' => $Location], 200);
    }

    public function locationSave(Request $request)
    {

        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:cities,city',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $data = [
            'user_id' => Auth::guard('user')->user()->id,
            'city' => $request->name,
        ];

        $data = Location::create($data);

        if ($data) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'error' => 'Something Wrong']);
    }

    public function locationAjaxcall(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $search_arr = $request->get('search');
        $searchValue = $search_arr['value'];
        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];

        $data = Location::query();

        if ($searchValue != null) {
            $data->where('city', 'like', '%' . $searchValue . '%');
        }

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->orderby('id', 'desc')->get();

        $data_arr = [];
        foreach ($list as $key => $record) {
            $id = $record->id;

            $action = ' <a class="dropdown-items update" href="javascript:void(0);"
           
            data-id="' . $id . '" ><i class="bi bi-pencil-fill"></i></a>';
            $action .= '<a class="dropdown-items delete" href="javascript:void(0);"
           
            data-id="' . $id . '"><i class="bi bi-trash-fill"></i></a>';

            $data_arr[] = [
                'id' => ++$start,
                'name' => $record->city,
                'date' => date('d-m-Y h:i a', strtotime($record->created_at)),
                'action' => $action,
            ];
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordswithFilter,
            'aaData' => $data_arr,
        ];

        echo json_encode($response);
        exit();
    }

    public function getLocation(Request $request)
    {

        $update = $request->update;
        $delete = $request->delete;

        if ($update) {
            $data = Location::where('id', $update)->first();
        }

        if ($delete) {
            $data = Location::where('id', $delete)->delete();
        }

        if ($data == null) {
            return response()->json(
                ['status' => 'error', 'message' => 'Record not found.']
            );
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function locationUpdate(Request $request)
    {

        $params = $request->all();

        $messages = [
            'name.unique' => 'The name must be unique. This name already exists.',
            'name.required' => 'Location city is required.',
        ];

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:cities,city,' . $request->id,
            ],
            $messages
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $data = [
            'city' => $request->name,
        ];

        $data = Location::where('id', $request->id)->update($data);

        if ($data) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'error' => 'Something Wrong']);
    }
}
