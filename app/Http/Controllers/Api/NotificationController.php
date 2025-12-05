<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Validator;

class NotificationController extends Controller
{
    public function notification(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'receiver_id' => 'required|integer',
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

        $settings = DB::table('notification_settings')
            ->where('user_id', $request->receiver_id)
            ->first();

        $query = DB::table('notification')
            ->where('receiver_id', $request->receiver_id);

        if ($settings) {
            if ($settings->new_message == 1) {
                $query->where('type', 'new_message');
            }

            if ($settings->new_matches == 1) {
                $query->orWhere('type', 'new_matches');
            }

            if ($settings->events == 1) {
                $query->orWhere('type', 'events');
            }
        }

        $notifications = $query->orderBy('id', 'desc')->get();

        return response()->json(
            [
                'success' => true,
                'data' => $notifications,
            ],
            200
        );
    }

    public function notificationsave(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'new_message' => 'nullable|integer',
                'user_id' => 'required|integer',
                'new_matches' => 'nullable|integer',
                'events' => 'nullable|integer',
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
            'user_id' => $request->user_id,
            'new_message' => $request->new_message,
            'new_matches' => $request->new_matches,
            'events' => $request->events,
        ];

        $check = DB::table('notification_settings')
            ->where('user_id', $request->user_id)->first();

        if ($check) {
            DB::table('notification_settings')
                ->where('user_id', $request->user_id)->update($data);
        } else {
            DB::table('notification_settings')->insert($data);
        }

        $notificationData = DB::table('notification_settings')
            ->where('user_id', $request->user_id)->first();

        if ($notificationData) {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $notificationData,
                ]
            );
        }

        return response()->json(
            [
                'status' => 'error',
                'error' => 'Something went wrong',
            ]
        );
    }
}
