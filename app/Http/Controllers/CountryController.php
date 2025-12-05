<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function country()
    {
        return view('master.country');
    }

    public function countrySave(Request $request)
    {
        $data = [
            'name' => $request->name,
            'iso_code' => $request->short_name,
            'country_code' => $request->iso_code,
        ];

        if ($request->id) {
            $save = Country::where('id', $request->id)->update($data);
        } else {
            $save = Country::create($data);
        }

        if ($save) {
            return response()->json(['status' => 'success', 'message' => 'success']);
        }

        return response()->json(['status' => 'error', 'message' => 'failed']);
    }

    public function countryList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchArr = $request->get('search');
        $searchValue = $searchArr['value'] ?? '';
        $orderArr = $request->get('order');
        $columnsArr = $request->get('columns');
        $columnIndex = $orderArr[0]['column'] ?? 0;
        $columnName = $columnsArr[$columnIndex]['data'] ?? 'id';
        $columnSortOrder = $orderArr[0]['dir'] ?? 'desc';

        $query = Country::query();

        if (! empty($searchValue)) {
            $query->where('name', 'like', '%' . $searchValue . '%');
        }

        $totalRecordsWithFilter = $query->count();
        $totalRecords = $totalRecordsWithFilter;
        $list = $query->skip($start)->take($length)->orderBy($columnName, $columnSortOrder)->get();

        $dataArr = [];
        foreach ($list as $key => $record) {
            $id = $record->id;
            $action = '<a class="dropdown-items update" href="javascript:void(0);" 
            
            data-id="' . $id . '"><i class="bi bi-pencil-fill"></i></a>';
            $action .= '<a class="dropdown-items delete" href="javascript:void(0);" 
            
            data-id="' . $id . '"><i class="bi bi-trash-fill"></i></a>';

            $dataArr[] = [
                'id' => ++$start,
                'name' => $record->name,
                'isocode' => $record->iso_code,
                'country_code' => $record->country_code,
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

    public function getcountry(Request $request)
    {
        $update = $request->update;
        $delete = $request->delete;
        $data = null;

        if ($update) {
            $data = Country::where('id', $update)->first();
        }

        if ($delete) {
            $data = Country::where('id', $delete)->delete();
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
}
