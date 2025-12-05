<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use Illuminate\Http\Request;
use Validator;

class ExerciseController extends Controller
{
    public function exercise()
    {
        return view('master.exercise');
    }

    public function exerciseSave(Request $request)
    {

        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:exercise,exercise',
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $image = $request->file('logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('exercise'), $imageName);

            $logoPath = 'exercise/' . $imageName;

            $data = [
                'exercise' => $params['name'],
                'logo' => $logoPath,
            ];

            Exercise::Create($data);

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Data saved successfully',
                    'data' => $data,
                ]
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No valid image file found.',
                ]
            );
        }
    }

    public function exerciseAjaxcall(Request $request)
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

        $data = Exercise::query();

        if ($searchValue != null) {
            $data->where('exercise', 'like', '%' . $searchValue . '%');
        }

        $totalRecordswithFilter = $data->count();
        $totalRecords = $totalRecordswithFilter;
        $list = $data->skip($start)->take($length)->orderby('id', 'desc')->get();

        $data_arr = [];
        foreach ($list as $key => $record) {
            $id = $record->id;
            $logoUrl = '<img src="' . asset('public/' . $record->logo) . '" alt="Logo"
           >';

            $action = ' <a class="dropdown-items update" href="javascript:void(0);"
           
            data-id="' . $id . '" ><i class="bi bi-pencil-fill"></i></a>';
            $action .= '<a class="dropdown-items delete" href="javascript:void(0);"
           
            data-id="' . $id . '"><i class="bi bi-trash-fill"></i></a>';

            $data_arr[] = [
                'id' => ++$start,
                'name' => $record->exercise,
                'logo' => $logoUrl,
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

    public function getexercise(Request $request)
    {

        $update = $request->update;
        $delete = $request->delete;

        if ($update) {
            $data = Exercise::where('id', $update)->first();
        }

        if ($delete) {
            $data = Exercise::where('id', $delete)->delete();
        }

        if ($data == null) {
            return response()->json(
                ['status' => 'error', 'message' => 'Record not found.']
            );
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function exerciseupdate(Request $request)
    {

        $params = $request->all();

        $rules = [
            'name' => 'required',
        ];

        if ($request->hasFile('logo')) {
            $rules['logo'] = 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048';
        }

        $validator = Validator::make($params, $rules);

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'errors',
                    'message' => $validator->errors(),
                ]
            );
        }

        $data = [
            'exercise' => $params['name'],
        ];

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $image = $request->file('logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('exercise'), $imageName);

            $logoPath = 'exercise/' . $imageName;
            $data['logo'] = $logoPath;
        }

        Exercise::where('id', $request->id)->update($data);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Data saved successfully',
                'data' => $data,
            ]
        );
    }
}
