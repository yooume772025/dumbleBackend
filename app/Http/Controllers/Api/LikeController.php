<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LikeUser;
use App\Models\MatchUser;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class LikeController extends Controller
{
    public function likeUser(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|integer|exists:users,id',
                'pre_user_id' => 'required|integer|exists:users,id',
                'status' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $validator->errors()->first(),
                ],
                422
            );
        }

        $likeUser = LikeUser::updateOrCreate(
            [
                'user_id' => $request->user_id,
                'pre_user_id' => $request->pre_user_id,
            ],
            [
                'status' => $request->status,
            ]
        );

        $reverseLike = LikeUser::where('user_id', $request->pre_user_id)
            ->where('pre_user_id', $request->user_id)
            ->first();

        if ($likeUser->status == 1 && $reverseLike && $reverseLike->status == 1) {
            $match1 = MatchUser::updateOrCreate(
                [
                    'user_id' => $request->user_id,
                    'pre_user_id' => $request->pre_user_id,
                ],
                [
                    'status' => 1,
                ]
            );

            $match2 = MatchUser::updateOrCreate(
                [
                    'user_id' => $request->pre_user_id,
                    'pre_user_id' => $request->user_id,
                ],
                [
                    'status' => 1,
                ]
            );

            LikeUser::where('user_id', $request->user_id)
                ->where('pre_user_id', $request->pre_user_id)
                ->delete();

            LikeUser::where('user_id', $request->pre_user_id)
                ->where('pre_user_id', $request->user_id)
                ->delete();

            DB::table('notification')->insert(
                [
                    'message' => "It's a match!",
                    'sender_id' => $request->user_id,
                    'receiver_id' => $request->pre_user_id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );

            return response()->json(
                [
                    'success' => true,
                    'message' => 'Match created successfully! Both users liked each other.',
                    'match_user' => $match1,
                ],
                200
            );
        } else {
            if ($likeUser->status == 0) {
                MatchUser::where('user_id', $request->user_id)
                    ->where('pre_user_id', $request->pre_user_id)
                    ->delete();

                MatchUser::where('user_id', $request->pre_user_id)
                    ->where('pre_user_id', $request->user_id)
                    ->delete();
            }

            return response()->json(
                [
                    'success' => true,
                    'message' => $likeUser->status == 1 ? 'Like recorded. Waiting for mutual like to create match.' : 'Unlike recorded.',
                    'like_user' => $likeUser,
                    'is_match' => false,
                ],
                200
            );
        }
    }

    public function likeYou(Request $request)
    {

        $user = User::where('id', $request->user_id)->first();

        if (! $user) {
            return response()->json(
                [
                    'message' => 'User not found',
                    'status' => false,
                ],
                404
            );
        }

        $likeme = LikeUser::where(
            'user_id',
            $request->user_id
        )->pluck('pre_user_id');

        $userlist = User::whereIn('id', $likeme)->get();

        $data = [];
        foreach ($userlist as $user) {
            $image = DB::table('gallery')
                ->where('user_id', $user->id)
                ->value('image_path');

            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'image' => $image,
            ];
        }

        return response()->json(
            [
                'status' => true,
                'data' => $data,
            ],
            200
        );
    }

    public function likeMe(Request $request)
    {

        $user = User::find($request->user_id);

        if (! $user) {
            return response()->json(
                [
                    'message' => 'User not found',
                    'status' => false,
                ],
                404
            );
        }

        $likers = LikeUser::where(
            'pre_user_id',
            $request->user_id
        )->pluck('user_id');

        $userList = User::whereIn('id', $likers)->get();

        $data = [];
        foreach ($userList as $user) {
            $image = DB::table('gallery')
                ->where('user_id', $user->id)
                ->value('image_path');

            $data[] = [
                'id' => $user->id,
                'name' => $user->name,
                'image' => $image,
            ];
        }

        return response()->json(
            [
                'status' => true,
                'data' => $data,
            ],
            200
        );
    }

    public function zodiac()
    {
        $userlist = DB::table('zodiac_signs')->get();

        return response()->json(
            [
                'status' => true,
                'data' => $userlist,
            ],
            200
        );
    }

    public function educationLabels()
    {
        $userlist = DB::table('education_labels')->get();

        return response()->json(
            [
                'status' => true,
                'data' => $userlist,
            ],
            200
        );
    }

    public function unmatchingList(Request $request)
    {
        $user = JWTAuth::parseToken()->authenticate();

        if (! $user) {
            return response()->json(
                [
                    'message' => 'User not found',
                    'status' => false,
                ],
                404
            );
        }

        $userId = $request->user_id;

        $unmatchedLikes = LikeUser::where('user_id', $userId)
            ->where('status', 1)
            ->get()
            ->filter(
                function ($like) {
                    $reverse = LikeUser::where('user_id', $like->pre_user_id)
                        ->where('pre_user_id', $like->user_id)
                        ->where('status', 1)
                        ->first();

                    return ! $reverse;
                }
            );

        $unmatchedUserIds = $unmatchedLikes->pluck('pre_user_id')->unique();

        $unmatchedUsers = User::whereIn('id', $unmatchedUserIds)->get();

        return response()->json(
            [
                'status' => true,
                'data' => $unmatchedUsers,
            ]
        );
    }
}
