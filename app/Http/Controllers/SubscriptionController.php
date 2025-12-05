<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use App\Models\Transacation;
use Illuminate\Http\Request;
use Validator;

class SubscriptionController extends Controller
{
    public function subscription()
    {
        return view('subscription.subscription');
    }

    public function subscriptionSave(Request $request)
    {

        $name = $request->name;
        $price = $request->price;
        $duration = $request->duration;
        $product_id = $request->product_id;
        $description = $request->description;
        $product_type = $request->product_type;

        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'name' => 'required',
                'price' => 'required',
                'duration' => 'required',
                'description' => 'required',
                'product_id' => 'required',
                'product_type' => 'required',
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
            'name' => $name,
            'price' => $price,
            'duration' => $duration,
            'product_id' => $product_id,
            'description' => $description,
            'product_type' => $product_type,
        ];

        Subscription::Create($data);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Data saved successfully',
                'data' => $data,
            ]
        );
    }

    public function subscriptionAjaxcall(Request $request)
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

        $data = Subscription::query();

        if ($searchValue != null) {
            $data->where('name', 'like', '%' . $searchValue . '%');
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
                'name' => $record->name,
                'price' => $record->price,
                'duration' => $record->duration,
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

    public function getsubscription(Request $request)
    {

        $update = $request->update;
        $delete = $request->delete;

        if ($update) {
            $data = Subscription::where('id', $update)->first();
        }

        if ($delete) {
            $data = Subscription::where('id', $delete)->delete();
        }

        if ($data == null) {
            return response()->json(
                ['status' => 'error', 'message' => 'Record not found.']
            );
        }

        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function subscriptionupdate(Request $request)
    {

        $name = $request->name;
        $price = $request->price;
        $duration = $request->duration;
        $product_id = $request->product_id;
        $description = $request->description;
        $product_type = $request->product_type;

        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'name' => 'required',
                'price' => 'required',
                'duration' => 'required',
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
            'name' => $name,
            'price' => $price,
            'duration' => $duration,
            'product_id' => $product_id,
            'description' => $description,
            'product_type' => $product_type,
        ];

        Subscription::where('id', $request->id)->update($data);

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Data saved successfully',
                'data' => $data,
            ]
        );
    }

    public function uerSubscription(Request $request)
    {
        return view('user.subscription');
    }

    public function uerSubscriptionAjaxcall(Request $request)
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

        $records = Transacation::join(
            'users',
            'transacation.user_id',
            '=',
            'users.id'
        )
            ->select(
                'transacation.*',
                'users.name',
                'users.email',
            )
            ->whereDate('transacation.end_date', '>=', now())
            ->orderBy('transacation.end_date', 'asc');

        $totalRecordswithFilter = $records->count();
        $totalRecords = $totalRecordswithFilter;

        $latestEndDate = $records->max('end_date');

        $list = $records->get();

        $subscriptions = $list->map(
            function ($subscription) use ($latestEndDate) {
                $subscription->is_current = (
                    $subscription->end_date == $latestEndDate
                ) ? true : false;

                return $subscription;
            }
        );

        $data_arr = [];

        foreach ($subscriptions as $sno => $record) {
            $data_arr[] = [
                'id' => ++$start,
                'name' => $record->name,
                'amount' => $record->amount ?? '',
                'payment_method' => $record->payment_method ?? '',
                'status' => $record->status ?? '',
                'currency' => $record->currency ?? '',
                'start_date' => $record->start_date ?? '',
                'end_date' => $record->end_date ?? '',
                'is_current' => $record->is_current ?? '',
                'email' => $record->email,
                'duration' => $record->duration,
                'date' => date('d-m-Y h:i a', strtotime($record->created_at)),
            ];
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordswithFilter,
            'aaData' => $data_arr,
        ];

        echo json_encode($response);
    }
}
