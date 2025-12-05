<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\SubService;
use Illuminate\Http\Request;
use Validator;

class SubServiceController extends Controller
{
    public function subService()
    {
        $Service = Service::all();

        return view('master.sub-service', compact('Service'));
    }

    public function subServiceSave(Request $request)
    {

        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:sub_service,sub_service_name,
            NULL,id,service_id,' . $request->subname,
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

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
            $image->move(public_path('service'), $imageName);

            $logoPath = 'service/' . $imageName;

            $data = [
                'service_id' => $request->name,
                'sub_service_name' => $request->subname,
                'logo' => $logoPath,
            ];

            SubService::create($data);

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

    public function subserviceAjaxcall(Request $request)
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

        $data = SubService::join(
            'service_master',
            'sub_service.service_id',
            'service_master.id'
        )
            ->select('sub_service.*', 'service_master.name as service_name');

        if ($searchValue != null) {
            $data->where('sub_service_name', 'like', '%' . $searchValue . '%');
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
                'name' => $record->service_name,
                'sub_service' => $record->sub_service_name,
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

    public function getsubservice(Request $request)
    {

        $update = $request->update;
        $delete = $request->delete;

        if ($update) {
            $data = SubService::where('id', $update)->first();
        }

        if ($delete) {
            $data = SubService::where('id', $delete)->delete();
        }

        if ($data == null) {
            return response()->json(
                ['status' => 'error', 'message' => 'Record not found.']
            );
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function subserviceupdate(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'name' => 'required|unique:sub_service,sub_service_name,' . $request->id . ',id,service_id,' . $request->subname,
            ]
        );

        if ($validator->fails()) {
            return response()->json([
                'status' => 'errors',
                'message' => $validator->errors()
            ]);
        }

        $data = [
            'service_id' => $request->name,
            'sub_service_name' => $request->subname,
        ];

        if ($request->hasFile('logo') && $request->file('logo')->isValid()) {
            $image = $request->file('logo');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('service'), $imageName);

            $logoPath = 'service/' . $imageName;
            $data['logo'] = $logoPath;
        }

        SubService::where('id', $request->id)->update($data);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Updated successfully',
                'data' => $data,
            ]
        );
    }
}
