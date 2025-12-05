<?php

namespace App\Http\Controllers;

use App\Models\Caption;
use Illuminate\Http\Request;
use Validator;

class CaptionController extends Controller
{
    public function caption()
    {
        return view('master.caption');
    }

    public function captionSave(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:caption_master,caption_name',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $data = [
            'caption_name' => $request->name,
        ];

        $data = Caption::create($data);

        if ($data) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'error' => 'Something Wrong']);
    }

    public function captionAjaxCall(Request $request)
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

        $data = Caption::query();

        if ($searchValue != null) {
            $data->where('caption_name', 'like', '%' . $searchValue . '%');
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
                'name' => $record->caption_name,
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

    public function getcaption(Request $request)
    {

        $update = $request->update;
        $delete = $request->delete;

        if ($update) {
            $data = Caption::where('id', $update)->first();
        }

        if ($delete) {
            $data = Caption::where('id', $delete)->delete();
        }

        if ($data == null) {
            return response()->json(
                ['status' => 'error',
                    'message' => 'Record not found.']
            );
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function captionupdate(Request $request)
    {

        $params = $request->all();

        $messages = [
            'name.unique' => 'The caption name must be unique.
            This caption name already exists.',
            'name.required' => 'caption name is required.',
        ];

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:caption_master,caption_name,' . $request->id,
            ],
            $messages
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors',
                    'message' => $validator->errors()]
            );
        }

        $data = [
            'caption_name' => $request->name,
        ];

        $data = Caption::where('id', $request->id)->update($data);

        if ($data) {
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error', 'error' => 'Something Wrong']);
    }
}
