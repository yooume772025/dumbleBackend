<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DeviceInfo;
use App\Models\User;
use App\Services\TwilioService;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Validator;

class RegisterController extends Controller
{
    protected $twilio;

    public function __construct(TwilioService $twilio)
    {
        $this->twilio = $twilio;
    }

    public function refresh(Request $request)
    {

        try {
            $newToken = JWTAuth::refresh(JWTAuth::getToken());

            return response()->json(
                [
                    'token' => $newToken,
                ]
            );
        } catch (JWTException $e) {
            return response()->json(
                [
                    'message' => 'Could not refresh the token',
                    'status' => false,
                ],
                500
            );
        }
    }

    public function userRegister(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'phone' => 'required|digits:10',
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

        $otp = config('services.twilio.demo_mode', false) ? '123456' : rand(100000, 999999);
        $phoneWithCountryCode = '+91' . $request->phone;
        $appName = config('app.name');
        $validity = 5;
        $message = "Your OTP code is: $otp\nFrom: $appName\nValid for: $validity minutes.";
        $user = User::where('mobile', $request->phone)->first();

        $smsSent = $this->twilio->sendSms($phoneWithCountryCode, $message);

        if (!$smsSent) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send SMS. Please try again.'
            ], 500);
        }

        if ($user) {
            $user->otp = $otp;
            $user->save();

            $message = 'You are already registered. OTP sent again.';
        } else {
            $user = User::create(
                [
                    'mobile' => $request->phone,
                    'otp' => $otp,
                ]
            );

            $message = 'OTP sent successfully. New user registered.';
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(
            [
                'message' => $message,
                'otp' => $otp,
                'token' => $token,
                'status' => true,
            ],
            200
        );
    }

    public function verifyOTP(Request $request)
    {
        $isDemoMode = config('services.twilio.demo_mode', false);
        if ($isDemoMode && $request->otp === '123456') {
            $user = User::where('mobile', $request->phone)->first();
            if (!$user) {
                return response()->json(['message' => 'User not found', 'status' => false], 404);
            }
            $token = JWTAuth::fromUser($user);
            return response()->json(['message' => 'Demo OTP verified successfully', 'token' => $token, 'status' => true], 200);
        }

        $user = User::where('otp', $request->otp)
            ->where('mobile', $request->phone)->first();

        if (! $user) {
            return response()->json(
                [
                    'message' => 'Invalid OTP',
                    'status' => false,
                ],
                404
            );
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(
            [
                'message' => 'OTP verified successfully',
                'token' => $token,
                'status' => true,
            ],
            200
        );
    }

    public function updateUserDetails(Request $request)
    {
        try {
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
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Unauthorized. Invalid or expired token.',
                    'status' => false,
                    'error' => $e->getMessage(),
                ],
                401
            );
        }

        $user = User::where('mobile', $request->phone)->first();

        if (! $user) {
            return response()->json(
                [
                    'message' => 'Invalid User Details',
                    'status' => false,
                ],
                404
            );
        }

        $dataToUpdate = [];

        if ($request->filled(['name', 'dob', 'age'])) {
            $dataToUpdate['name'] = $request->name;
            $dataToUpdate['dob'] = $request->dob;
            $dataToUpdate['age'] = $request->age;
        }

        if ($request->filled(['gender', 'subgender'])) {
            $dataToUpdate['gender_id'] = $request->gender;
            $dataToUpdate['sub_gender_id'] = $request->subgender;
        } elseif ($request->filled('gender')) {
            $dataToUpdate['gender_id'] = $request->gender;
        }

        if ($request->filled('height')) {
            $dataToUpdate['height_id'] = $request->height;
        }

        if ($request->filled('service')) {
            $dataToUpdate['service'] = $request->service;
        }

        if ($request->filled(['about', 'description'])) {
            $dataToUpdate['about'] = $request->about;
            $dataToUpdate['description'] = $request->description;
        } elseif ($request->filled('about')) {
            $dataToUpdate['about'] = $request->about;
        }

        if ($request->filled('relation')) {
            $dataToUpdate['relation'] = $request->relation;
        }

        if (empty($dataToUpdate)) {
            return response()->json(
                [
                    'message' => 'No valid fields to update.',
                    'status' => false,
                ],
                400
            );
        }

        try {
            $user->update($dataToUpdate);

            return response()->json(
                [
                    'message' => 'User details updated successfully!',
                    'status' => true,
                ],
                200
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'message' => 'Failed to update user details!',
                    'status' => false,
                    'error' => $e->getMessage(),
                ],
                422
            );
        }
    }

    public function facebookLogin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'facebook_id' => 'required|string|unique:users,facebook_id,NULL,id,deleted_at,NULL',
                'email' => 'nullable|email',
                'name' => 'required|string',
                'phone' => 'nullable|string',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                422
            );
        }
        $user = User::where('facebook_id', $request->google_id)->first();

        if (! $user) {
            $user = User::create(
                [
                    'facebook_id' => $request->google_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => bcrypt(Str::random(16)),
                ]
            );
        } else {
            $user->update(
                [
                    'email' => $request->email ?? $user->email,
                    'phone' => $request->phone ?? $user->phone,
                    'avatar' => $request->avatar ?? $user->avatar,
                ]
            );
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(
            [
                'status' => true,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ]
        );
    }

    public function applyFilter(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|numeric',
                'gender' => 'nullable|array',
                'language' => 'nullable|string',
                'fromage' => 'nullable|numeric',
                'toage' => 'nullable|numeric',
                'relation' => 'nullable|string',
                'far_away' => 'nullable|string',
                'verified' => 'nullable|boolean',
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

        $user = User::where('id', $request->id)->first();

        if ($user == null) {
            return response()->json(
                [
                    'message' => 'Invalid User Details',
                    'status' => false,
                ],
                404
            );
        }

        $data = [
            'user_id' => $request->id,
            'mobile' => $request->phone,
            'gender' => json_encode($request->gender),
            'language' => $request->language,
            'from_age' => $request->fromage,
            'to_age' => $request->toage,
            'relation' => $request->relation,
            'location' => $request->far_away,
            'verified_user' => $request->verified,
        ];

        $settings = DB::table('user_settings')
            ->where('user_id', $request->id)->first();

        if ($settings != null) {
            $settings = DB::table('user_settings')
                ->where('user_id', $request->id)->update($data);
        } else {
            $settings = DB::table('user_settings')->insert($data);
        }

        if ($settings) {
            return response()->json(
                ['success' => true, 'message' => 'Success!'],
                200
            );
        }

        return response()->json(
            ['success' => false, 'message' => 'Failed!'],
            400
        );
    }

    public function getFilter(Request $request)
    {
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

        $settings = DB::table('user_settings')
            ->where('user_id', $request->user_id)->first();

        if ($settings) {
            return response()->json(
                ['success' => true, 'message' => 'Success!', 'data' => $settings],
                200
            );
        }

        return response()->json(
            ['success' => false, 'message' => 'Filter data not found'],
            400
        );
    }

    public function googleLogin(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'google_id' => 'required',
                'email' => 'nullable|email',
                'name' => 'required|string',
                'phone' => 'nullable|string',
            ]
        );
        if ($validator->fails()) {
            return response()->json(
                [
                    'status' => false,
                    'errors' => $validator->errors(),
                ],
                422
            );
        }
        $user = User::where('google_id', $request->google_id)->first();

        if (! $user) {
            $user = User::create(
                [
                    'google_id' => $request->google_id,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'password' => bcrypt(Str::random(16)),
                ]
            );
        } else {
            $user->update(
                [
                    'email' => $request->email ?? $user->email,
                    'phone' => $request->phone ?? $user->phone,
                    'avatar' => $request->avatar ?? $user->avatar,
                ]
            );
        }

        $token = JWTAuth::fromUser($user);

        return response()->json(
            [
                'status' => true,
                'message' => 'Login successful',
                'user' => $user,
                'token' => $token,
            ]
        );
    }

    public function deviceInfo(Request $request)
    {
        $data = $request->all();
        if (! isset($data['phone_name']) || ! isset($data['phone_no']) || ! isset($data['phone_address'])) {
            return response()->json(
                [
                    'status' => false,
                    'message' => 'Missing required fields: phone_name, phone_no, or phone_address',
                ],
                422
            );
        }
        $ipAddress = $request->ip();

        $device = DeviceInfo::create(
            [
                'phone_name' => $data['phone_name'],
                'phone_no' => $data['phone_no'],
                'phone_address' => $data['phone_address'],
                'ip_address' => $ipAddress,
            ]
        );

        return response()->json(
            [
                'status' => true,
                'message' => 'Device information saved successfully',
                'data' => $device,
            ]
        );
    }

    public function completeProfile(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required|exists:users,id',
                'looking_for' => 'nullable|array',
                'user_interests' => 'nullable|array',
                'photo_url' => 'nullable|array',
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

        $user_id = $request->user_id;

        $user = User::where('id', $user_id)->first();

        if (! $user) {
            return response()->json(
                [
                    'message' => 'Invalid User Details',
                    'status' => false,
                ],
                404
            );
        }
        $updateData = $request->except(['id']);

        if (isset($updateData['user_interests']) && is_array($updateData['user_interests'])) {
            $updateData['user_interests'] = $updateData['user_interests'];
        }
        if (isset($updateData['looking_for']) && is_array($updateData['looking_for'])) {
            $updateData['looking_for'] = $updateData['looking_for'];
        }
        if ($request->hasFile('photo_url')) {
            $imagePaths = [];
            foreach ($request->file('photo_url') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads'), $imageName);
                    $imagePaths[] = 'uploads/' . $imageName;
                }
            }
            $updateData['photo_url'] = json_encode($imagePaths);
        }

        if (! empty($updateData)) {
            $user->update($updateData);
        }

        $education = DB::table('user_educations')
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->select('institute', 'course', 'year')
            ->first();

        $job = DB::table('user_jobs')
            ->where('user_id', $user_id)
            ->where('status', 1)
            ->select('title', 'company')
            ->first();

        $gallery = DB::table('gallery')
            ->where('user_id', $user_id)
            ->get();

        $profile_image = DB::table('gallery')
            ->where('user_id', $user_id)
            ->first();

        return response()->json(
            [
                'message' => 'Success',
                'data' => [
                    'user' => $user,
                    'education' => $education,
                    'job' => $job,
                    'image' => $profile_image,
                    'gallery' => $gallery,
                ],
                'status' => true,
            ],
            200
        );
    }

    public function userDetails(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'phone' => 'required_without:id|string',
                'id' => 'required_without:phone|integer|exists:users,id',
                'looking_for' => 'nullable|array',
                'user_interests' => 'nullable|array',
                'photo_url' => 'nullable|array',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'errors', 'message' => $validator->errors()]
            );
        }

        $userQuery = User::query();

        if ($request->filled('phone')) {
            $userQuery->where('mobile', $request->phone);
        }
        if ($request->filled('id')) {
            $userQuery->where('id', $request->id);
        }

        $user = $userQuery->first();

        if (! $user) {
            return response()->json(
                [
                    'message' => 'Invalid User Details',
                    'status' => false,
                ],
                404
            );
        }
        $updateData = $request->except(['phone']);
        if (isset($updateData['user_interests']) && is_array($updateData['user_interests'])) {
            $updateData['user_interests'] = $updateData['user_interests'];
        }
        if (isset($updateData['looking_for']) && is_array($updateData['looking_for'])) {
            $updateData['looking_for'] = $updateData['looking_for'];
        }
        if ($request->hasFile('photo_url')) {
            $imagePaths = [];
            foreach ($request->file('photo_url') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->move(public_path('uploads'), $imageName);
                    $imagePaths[] = 'uploads/' . $imageName;
                }
            }
            $updateData['photo_url'] = json_encode($imagePaths);
        }
        if (! empty($updateData)) {
            $user->update($updateData);
        }
        if (! empty($user->photo_url) && is_string($user->photo_url)) {
            $user->photo_url = json_decode($user->photo_url, true);
        }

        return response()->json(
            [
                'message' => 'User details fetched and updated successfully!',
                'data' => $user,
                'status' => true,
            ],
            200
        );
    }

    public function userList(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        if ($user == null) {
            return response()->json(
                [
                    'message' => 'Invalid User Details',
                    'status' => false,
                ],
                404
            );
        }

        $filter = DB::table('user_settings')
            ->where('user_id', $request->id)->first();

        $data = User::query()->where('id', '!=', $user->id);

        if ($filter) {
            if ($filter->gender) {
                $genders = is_array($filter->gender) ?
                $filter->gender : explode(',', $filter->gender);
                $data->whereIn('gender_id', $genders);
            }

            if ($filter->from_age != null && $filter->to_age != null) {
                $data->whereBetween('age', [$filter->from_age, $filter->to_age]);
            }

            if ($filter->location && $request->latitude && $request->longitude) {
                $latitude = $user->latitude;
                $longitude = $user->longitude;
                $radius = $filter->location;

                $data->select(
                    '*',
                    DB::raw(
                        "(
                    6371 * acos(
                        cos(radians($latitude)) *
                        cos(radians(latitude)) *
                        cos(radians(longitude) - radians($longitude)) +
                        sin(radians($latitude)) *
                        sin(radians(latitude))
                    )
                ) AS distance"
                    )
                )
                    ->having('distance', '<=', $radius);
            }
        }

        $likeuser = DB::table('like_user')
            ->where('user_id', $request->id)->pluck('pre_user_id');

        if ($likeuser && $likeuser->isNotEmpty()) {
            $data->whereNotIn('id', $likeuser);
        }

        $blockuser = DB::table('block_user')
            ->where('user_id', $request->id)->pluck('pre_user_id');

        if ($blockuser && $blockuser->isNotEmpty()) {
            $data->whereNotIn('id', $blockuser);
        }

        $report_user = DB::table('report_user')
            ->where('user_id', $request->id)->pluck('pre_user_id');

        if ($report_user && $report_user->isNotEmpty()) {
            $data->whereNotIn('id', $report_user);
        }

        if ($request->language != null) {
            $data->where('language', $request->language);
        }

        $users = $data->paginate(15);

        foreach ($users as $user) {
            $gallery_image = DB::table('gallery')->where('user_id', $user->id)
                ->value('image_path');
            $user->gallery_image = $gallery_image;

            if ($user->hide_name == '1') {
                $user->name = null;
            }
        }

        return response()->json(['success' => true, 'data' => $users], 200);
    }

    public function userListtab(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        if (! $user) {
            return response()->json(
                [
                    'message' => 'Invalid User Details',
                    'status' => false,
                ],
                404
            );
        }

        $seenUserIds = DB::table('like_user')
            ->where('user_id', $user->id)
            ->pluck('pre_user_id')
            ->toArray();

        $data = User::query()
            ->where('id', '!=', $user->id)
            ->whereNotIn('id', $seenUserIds);
        if ($request->tab === 'new') {
            $data->orderBy('created_at', 'desc');
        } elseif ($request->tab === 'nearby') {
            $latitude = $user->latitude;
            $longitude = $user->longitude;
            $radius = 2;

            $data->select(
                '*',
                DB::raw(
                    "(
                6371 * acos(
                    cos(radians($latitude)) *
                    cos(radians(latitude)) *
                    cos(radians(longitude) - radians($longitude)) +
                    sin(radians($latitude)) *
                    sin(radians(latitude))
                )
            ) AS distance"
                )
            )
                ->having('distance', '<=', $radius)
                ->orderBy('distance');
        } elseif ($request->tab === 'recently_active') {
            $minutesAgo = now()->subMinutes(59);
            $data->where('updated_at', '>=', $minutesAgo);
        } else {
        }

        $users = $data->get();
        foreach ($users as $user) {
            $gallery_image = DB::table('gallery')
                ->where('user_id', $user->id)
                ->value('image_path');
            $user->gallery_image = $gallery_image;
            $user_jobs = DB::table('user_jobs')
                ->where('user_id', $user->id)
                ->value('title');
            $user->user_jobs = $user_jobs;
        }

        return response()->json(['success' => true, 'data' => $users], 200);
    }
}
