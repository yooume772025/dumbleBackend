<?php

namespace App\Http\Controllers;

use App\Models\About;
use Illuminate\Http\Request;
use Validator;

class AboutController extends Controller
{
    public function about()
    {
        return view('master.about');
    }

    public function aboutSave(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:about_master,name',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'errors',
                    'message' => $validator->errors(),
                ]
            );
        }

        $data = [
            'name' => $request->name,
        ];

        $data = About::create($data);

        if ($data) {
            return response()->json(
                [
                    'status' => 'success',
                ]
            );
        }

        return response()->json(
            [
                'status' => 'error',
                'error' => 'Something Wrong',
            ]
        );
    }

    public function aboutAjaxcall(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchArr = $request->get('search');
        $searchValue = $searchArr['value'];
        $columnIndexArr = $request->get('order');
        $columnNameArr = $request->get('columns');
        $orderArr = $request->get('order');
        $columnIndex = $columnIndexArr[0]['column'];
        $columnName = $columnNameArr[$columnIndex]['data'];
        $columnSortOrder = $orderArr[0]['dir'];

        $data = About::query();

        if ($searchValue !== null) {
            $data->where('name', 'like', '%' . $searchValue . '%');
        }

        $totalRecordsWithFilter = $data->count();
        $totalRecords = $totalRecordsWithFilter;
        $list = $data->skip($start)->take($length)->orderBy('id', 'desc')->get();

        $dataArr = [];
        foreach ($list as $key => $record) {
            $id = $record->id;

            $action = ' <a class="dropdown-items update" href="javascript:void(0);"
           
            data-id="' . $id . '" ><i class="bi bi-pencil-fill"></i></a>';
            $action .= '<a class="dropdown-items delete" href="javascript:void(0);"
           
            data-id="' . $id . '"><i class="bi bi-trash-fill"></i></a>';

            $dataArr[] = [
                'id' => ++$start,
                'name' => $record->name,
                'date' => date('d-m-Y h:i a', strtotime($record->created_at)),
                'action' => $action,
            ];
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordsWithFilter,
            'aaData' => $dataArr,
        ];

        echo json_encode($response);
        exit();
    }

    public function getAbout(Request $request)
    {
        $update = $request->update;
        $delete = $request->delete;
        $data = null;

        if ($update) {
            $data = About::where('id', $update)->first();
        }

        if ($delete) {
            $data = About::where('id', $delete)->delete();
        }

        if ($data === null) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Record not found.',
                ]
            );
        }

        return response()->json(
            [
                'status' => 'success',
                'data' => $data,
            ]
        );
    }

    public function aboutUpdate(Request $request)
    {
        $params = $request->all();

        $messages = [
            'name.unique' => 'The about name must be unique. This about name already exists.',
            'name.required' => 'about name is required.',
        ];

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:about_master,name,' . $request->id,
            ],
            $messages
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'errors',
                    'message' => $validator->errors(),
                ]
            );
        }

        $data = [
            'name' => $request->name,
        ];

        $data = About::where('id', $request->id)->update($data);

        if ($data) {
            return response()->json(
                [
                    'status' => 'success',
                ]
            );
        }

        return response()->json(
            [
                'status' => 'error',
                'error' => 'Something Wrong',
            ]
        );
    }
}
