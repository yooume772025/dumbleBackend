<?php

namespace App\Http\Controllers;

use App\Models\Gender;
use App\Models\SubGender;
use Illuminate\Http\Request;
use Validator;

class SubGenderController extends Controller
{
    public function subgender()
    {
        $gender = Gender::all();

        return view('master.sub-gender', compact('gender'));
    }

    public function subgenderSave(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:sub_gender,sub_gender_name,NULL,id,gender_id,
            ' . $request->gender,
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $data = [
            'gender_id' => $request->gender,
            'sub_gender_name' => $request->name,
        ];

        $insert = SubGender::create($data);

        if ($insert) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'error' => 'Something Wrong']);
    }

    public function subgenderAjaxcall(Request $request)
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

        $data = SubGender::join(
            'gender_master',
            'sub_gender.gender_id',
            'gender_master.id'
        )
            ->select('sub_gender.*', 'gender_master.gender_name as gender_name');

        if ($searchValue != null) {
            $data->where('gender_name', 'like', '%' . $searchValue . '%')
                ->orWhere('sub_gender_name', 'like', '%' . $searchValue . '%');
        }

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->orderby('id', 'desc')->get();

        $data_arr = [];
        foreach ($list as $key => $record) {
            $id = $record->id;

            $action = ' <a class="dropdown-items update" href="javascript:void(0);" 
            
            data-id="' . $id . '" ><i class="bi bi-pencil-squre-fill"></i></a>';
            $action .= '<a class="dropdown-items delete" href="javascript:void(0);" 
            
            data-id="' . $id . '"><i class="bi bi-trash-fill"></i></a>';

            $data_arr[] = [
                'id' => ++$start,
                'name' => $record->gender_name,
                'subgender' => $record->sub_gender_name,
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

    public function getsubgender(Request $request)
    {
        $update = $request->update;
        $delete = $request->delete;

        if ($update) {
            $data = SubGender::where('id', $update)->first();
        }

        if ($delete) {
            $data = SubGender::where('id', $delete)->delete();
        }

        if ($data == null) {
            return response()->json(
                ['status' => 'error', 'message' => 'Record not found.']
            );
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function subgenderupdate(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:sub_gender,sub_gender_name,
            ' . $request->id . ',id,gender_id,' . $request->gender,
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $data = [
            'gender_id' => $request->gender,
            'sub_gender_name' => $request->name,
        ];

        $insert = SubGender::where('id', $request->id)->update($data);

        if ($insert) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'error' => 'Something Wrong']);
    }
}
