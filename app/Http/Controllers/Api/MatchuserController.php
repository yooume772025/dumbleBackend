<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\LikeUser;
use App\Models\MatchUser;
use App\Models\Message;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Validator;

class MatchuserController extends Controller
{
    public function matchuser(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required|exists:users,id',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $userId = $request->user_id;
        $preUserId = $request->pre_user_id;
        $newStatus = $request->input('status', null);

        $matchA = MatchUser::where('user_id', $userId)
            ->where('pre_user_id', $preUserId)
            ->first();

        $matchB = MatchUser::where('user_id', $preUserId)
            ->where('pre_user_id', $userId)
            ->first();

        if ($matchA && $matchA->status == 1 && $matchB && $matchB->status == 1) {
            if (! is_null($newStatus)) {
                $matchA->status = $newStatus;
                $matchA->save();

                $matchB->status = $newStatus;
                $matchB->save();
            }

            return response()->json(
                [
                    'success' => true,
                    'status' => $matchA->status,
                    'user_id' => $userId,
                    'pre_user_id' => $preUserId,
                    'msg' => 'User matched',
                ],
                200
            );
        }

        return response()->json(
            [
                'success' => false,
                'status' => 0,
                'user_id' => $userId,
                'pre_user_id' => $preUserId,
                'msg' => 'User not matched',
            ],
            200
        );
    }

    public function matchinglist(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required|exists:users,id',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $userId = $request->user_id;

        $likedUsers = MatchUser::where('user_id', $userId)
            ->where('status', 1)
            ->pluck('pre_user_id')
            ->toArray();

        $likedByUsers = MatchUser::where('pre_user_id', $userId)
            ->where('status', 1)
            ->pluck('user_id')
            ->toArray();

        $mutualUserIds = array_intersect($likedUsers, $likedByUsers);

        $matchedUsers = User::whereIn('id', $mutualUserIds)->get();

        $matchedUsers = $matchedUsers->map(
            function ($user) {
                $galleryImage = \App\Models\Gallery::where('user_id', $user->id)->value('image_path');

                $user->image = $galleryImage;

                return $user;
            }
        );

        return response()->json(
            [
                'status' => true,
                'data' => $matchedUsers,
            ]
        );
    }

    public function unmatching(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required|exists:users,id',
                'pre_user_id' => 'required|exists:users,id',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $userId = $request->user_id;
        $preUserId = $request->pre_user_id;

        MatchUser::where('user_id', $userId)
            ->where('pre_user_id', $preUserId)
            ->delete();

        Message::where('sender_id', $userId)
            ->where('receiver_id', $preUserId)
            ->update(['status' => 1]);

        return response()->json(
            [
                'status' => true,
                'message' => 'Unmatched successfully',
            ]
        );
    }

    public function removeMatchinglist(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required|exists:users,id',
                'pre_user_id' => 'required|exists:users,id',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $userId = $request->user_id;
        $preUserId = $request->pre_user_id;

        MatchUser::where('user_id', $userId)
            ->where('pre_user_id', $preUserId)
            ->update(['status' => 0]);

        return response()->json(
            [
                'status' => true,
                'message' => 'Unmatched successfully',
            ]
        );
    }

    public function detect(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required|exists:users,id',
                'image' => 'required|image|max:2048',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $user = User::find($request->user_id);

        $apiKey = env('FACE_API_KEY');
        $apiSecret = env('FACE_API_SECRET');
        $apiUrl = env('FACE_API_URL', 'https://api-us.faceplusplus.com/facepp/v3/detect');

        if (empty($apiKey) || empty($apiSecret)) {
            $image = $request->file('image');
            $imageSize = getimagesize($image->getPathname());

            if ($imageSize === false) {
                return response()->json([
                    'status' => 'error',
                    'is_human_face' => false,
                    'message' => 'Invalid image file. Please upload a valid image.',
                ], 400);
            }

            $width = $imageSize[0];
            $height = $imageSize[1];

            if ($width < 100 || $height < 100) {
                return response()->json([
                    'status' => 'error',
                    'is_human_face' => false,
                    'message' => 'Image too small. Please upload a larger image (minimum 100x100 pixels).',
                ], 400);
            }

            User::where('id', $request->user_id)->update(['verified' => true]);

            return response()->json([
                'status' => 'success',
                'is_human_face' => true,
                'message' => 'Image validated successfully. Note: Face detection API not configured.',
                'user' => $user,
                'warning' => 'Face detection API credentials not configured. Using basic image validation only.'
            ]);
        }

        try {
            $image = fopen($request->file('image')->getPathname(), 'r');

            $response = Http::timeout(30)
                ->attach('image_file', $image, 'image.jpg')
                ->post($apiUrl, [
                    'api_key' => $apiKey,
                    'api_secret' => $apiSecret,
                ]);

            if ($response->failed()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Face detection API call failed: ' . $response->body(),
                ], 500);
            }

            $result = $response->json();

            if (!empty($result['faces']) && count($result['faces']) > 0) {
                User::where('id', $request->user_id)->update(['verified' => true]);

                return response()->json([
                    'status' => 'success',
                    'is_human_face' => true,
                    'message' => 'Human face detected successfully.',
                    'user' => $user,
                    'face_count' => count($result['faces']),
                ]);
            } else {
                return response()->json([
                    'status' => 'success',
                    'is_human_face' => false,
                    'message' => 'No human face detected in the image.',
                    'user' => $user,
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Face detection service error: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function discovery(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required',
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

        $user = User::where('id', $request->user_id)->first();

        if ($user == null) {
            return response()->json(
                [
                    'message' => 'Invalid User Details',
                    'status' => false,
                ],
                404
            );
        }

        if (! $user->latitude || ! $user->longitude) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'User latitude and longitude not available.',
                ],
                400
            );
        }

        $latitude = $user->latitude;
        $longitude = $user->longitude;

        $data = User::query()
            ->where('id', '!=', $user->id)
            ->whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->select(
                'users.*',
                DB::raw(
                    "(
                6371 * acos(
                    cos(radians($latitude)) *
                    cos(radians(users.latitude)) *
                    cos(radians(users.longitude) - radians($longitude)) +
                    sin(radians($latitude)) *
                    sin(radians(users.latitude))
                )
            ) AS distance"
                )
            )
            ->orderBy('distance', 'asc');

        $seenUserIds = DB::table('like_user')
            ->where('user_id', $user->id)
            ->pluck('pre_user_id')
            ->toArray();

        $matchedUserIds = DB::table('matching_user')
            ->where('user_id', $user->id)
            ->where('status', 1)
            ->pluck('pre_user_id')
            ->toArray();

        $excludedUserIds = array_unique(array_merge($seenUserIds, $matchedUserIds));

        $users = User::query()
            ->where('id', '!=', $user->id)
            ->whereNotIn('id', $excludedUserIds)
            ->paginate(10);

        $users = $users->map(
            function ($user) {
                if (isset($user->distance)) {
                    $user->distance = round($user->distance, 2) . ' km';
                } else {
                    $user->distance = null;
                }

                $galleryImage = \App\Models\Gallery::where(
                    'user_id',
                    $user->id
                )->value('image_path');
                $user->image = $galleryImage ?? null;

                return $user;
            }
        );

        return response()->json(
            [
                'success' => true,
                'data' => $users,
            ],
            200
        );
    }

    public function matchProfile(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required|exists:users,id',
                'pre_user_id' => 'required|exists:users,id',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => $validator->errors(),
                ],
                422
            );
        }

        $userLike = LikeUser::where('user_id', $params['user_id'])
            ->where('pre_user_id', $params['pre_user_id'])
            ->where('status', 1)
            ->first();

        $preUserLike = LikeUser::where('user_id', $params['pre_user_id'])
            ->where('pre_user_id', $params['user_id'])
            ->where('status', 1)
            ->first();

        if (!$userLike || !$preUserLike) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No mutual match found - both users must like each other',
                ],
                404
            );
        }

        $match1 = MatchUser::updateOrCreate(
            [
                'user_id' => $params['user_id'],
                'pre_user_id' => $params['pre_user_id'],
            ],
            [
                'status' => 1,
            ]
        );

        $match2 = MatchUser::updateOrCreate(
            [
                'user_id' => $params['pre_user_id'],
                'pre_user_id' => $params['user_id'],
            ],
            [
                'status' => 1,
            ]
        );

        LikeUser::where('user_id', $params['user_id'])
            ->where('pre_user_id', $params['pre_user_id'])
            ->delete();

        LikeUser::where('user_id', $params['pre_user_id'])
            ->where('pre_user_id', $params['user_id'])
            ->delete();
            
        $user = User::select('id', 'name')->find($params['user_id']);
        $preUser = User::select('id', 'name')->find($params['pre_user_id']);

        if (!$user || !$preUser) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'One or both users not found',
                ],
                404
            );
        }

        $userImage = Gallery::where('user_id', $user->id)->select('image_path')->first();
        $preUserImage = Gallery::where('user_id', $preUser->id)->select('image_path')->first();

        $data = [
            'user' => [
                'details' => [
                    'id' => $user->id,
                    'name' => $user->name,
                ],
                'image' => $userImage ? $userImage->image_path : null,
                'firstImage' => $userImage ? $userImage->image_path : null,
            ],
            'pre_user' => [
                'details' => [
                    'id' => $preUser->id,
                    'name' => $preUser->name,
                ],
                'image' => $preUserImage ? $preUserImage->image_path : null,
                'firstImage' => $preUserImage ? $preUserImage->image_path : null,
            ],
        ];

        return response()->json(
            [
                'status' => 'success',
                'data' => $data,
            ],
            200
        );
    }

    public function chatStartedList(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required|exists:users,id',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $userId = $request->user_id;

        $chatStartedUsers = MatchUser::where('user_id', $userId)
            ->where('status', 2)
            ->pluck('pre_user_id')
            ->toArray();

        $chatStartedByUsers = MatchUser::where('pre_user_id', $userId)
            ->where('status', 2)
            ->pluck('user_id')
            ->toArray();

        $mutualUserIds = array_intersect($chatStartedUsers, $chatStartedByUsers);

        $users = User::whereIn('id', $mutualUserIds)->get();

        $users = $users->map(
            function ($user) {
                $galleryImage = \App\Models\Gallery::where('user_id', $user->id)->value('image_path');

                $user->image = $galleryImage;

                return $user;
            }
        );

        return response()->json(
            [
                'status' => true,
                'data' => $users,
            ]
        );
    }
}
