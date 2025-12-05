<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\Message;
use App\Models\User;
use DB;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function uploadUserGallery(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'user_id'     => 'required|exists:users,id',
                'photo_url'   => 'required|array|min:3|max:6', // Allow 3 to 6 images
                'photo_url.*' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                'status'  => 'error',
                'message' => $validator->errors(),

                ],
                422
            );
        }

        $user = User::find($request->user_id);
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }

        $oldImages = Gallery::where('user_id', $user->id)->get();
        foreach ($oldImages as $oldImage) {
            $oldFilePath = public_path($oldImage->image_path);
            if (file_exists($oldFilePath)) {
                @unlink($oldFilePath);
            }
            $oldImage->delete();
        }

        $savedImages = [];
        $uploadedCount = 0;

        foreach ($request->file('photo_url') as $index => $file) {
            $extension = $file->getClientOriginalExtension();
            $photoNumber = $index + 1;
            $uniqueFilename = 'photo_' . $photoNumber . '.' . $extension;

            $destinationPath = public_path('uploads/gallery');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            try {
                $file->move($destinationPath, $uniqueFilename);

                $gallery = new Gallery();
                $gallery->user_id = $user->id;
                $gallery->image_path = 'uploads/gallery/' . $uniqueFilename;
                $gallery->save();

                $savedImages[] = $gallery;
                $uploadedCount++;
            } catch (\Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Failed to upload image " . ($index + 1) . ": " . $e->getMessage()
                ], 500);
            }
        }


        if ($uploadedCount < 3 || $uploadedCount > 6) {
            return response()->json(
                [
                'status'  => false,
                'message' => "You must upload between 3 and 6 images. Uploaded: {$uploadedCount}.",
                'uploaded_count' => $uploadedCount,
                'expected_min' => 3,
                'expected_max' => 6
                ],
                422
            );
        }

        return response()->json(
            [
            'status'  => true,
            'message' => 'All 6 gallery images uploaded successfully.',
            'images'  => $savedImages,
            'uploaded_count' => $uploadedCount
            ]
        );
    }

    public function updateUserGallery(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'gallery_id' => 'required|exists:gallery,id',
                'user_id' => 'required|exists:users,id',
                'image_path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status'  => 'error',
                    'message' => $validator->errors(),
                ],
                422
            );
        }


        $existingGallery = Gallery::where('id', $request->gallery_id)
                                 ->where('user_id', $request->user_id)
                                 ->first();

        if (!$existingGallery) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Gallery record not found or access denied.',
                ],
                404
            );
        }

        $file = $request->file('image_path');


        $extension = $file->getClientOriginalExtension();
        $uniqueFilename = 'photo_replaced_' . $request->gallery_id . '.' . $extension;

        $destinationPath = public_path('uploads/gallery');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        try {
            if (file_exists(public_path($existingGallery->image_path))) {
                unlink(public_path($existingGallery->image_path));
            }


            $file->move($destinationPath, $uniqueFilename);


            $existingGallery->image_path = 'uploads/gallery/' . $uniqueFilename;
            $existingGallery->save();



            return response()->json(
                [
                    'status'  => true,
                    'message' => 'Gallery image updated successfully.',
                    'gallery' => $existingGallery,
                    'old_path' => $existingGallery->image_path,
                    'new_path' => 'uploads/gallery/' . $uniqueFilename
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to update image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteUserGallery(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:gallery,id',
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

        $gallery = Gallery::where('id', $request->id)->delete();

        return response()->json(
            [
                'status' => true,
                'message' => 'Gallery image updated successfully.',
            ]
        );
    }

    public function replaceGalleryImage(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [
                'gallery_id' => 'required|exists:gallery,id',
                'user_id' => 'required|exists:users,id',
                'new_image' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'status'  => 'error',
                    'message' => $validator->errors(),
                ],
                422
            );
        }


        $existingGallery = Gallery::where('id', $request->gallery_id)
                                 ->where('user_id', $request->user_id)
                                 ->first();

        if (!$existingGallery) {
            return response()->json(
                [
                    'status'  => false,
                    'message' => 'Gallery record not found or access denied.',
                ],
                404
            );
        }

        $file = $request->file('new_image');


        $extension = $file->getClientOriginalExtension();
        $uniqueFilename = 'photo_replaced_' . $request->gallery_id . '.' . $extension;

        $destinationPath = public_path('uploads/gallery');

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }

        try {
            $oldImagePath = $existingGallery->image_path;


            if (file_exists(public_path($oldImagePath))) {
                unlink(public_path($oldImagePath));
            }


            $file->move($destinationPath, $uniqueFilename);


            $existingGallery->image_path = 'uploads/gallery/' . $uniqueFilename;
            $existingGallery->save();



            return response()->json(
                [
                    'status'  => true,
                    'message' => 'Gallery image replaced successfully.',
                    'gallery' => $existingGallery,
                    'old_path' => $oldImagePath,
                    'new_path' => $existingGallery->image_path
                ]
            );
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to replace image: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUserGallery($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(
                ['status' => false, 'message' => 'User not found'],
                404
            );
        }

        $gallery = Gallery::where('user_id', $user_id)->get();
        $imageCount = $gallery->count();

        return response()->json(
            [
                'status' => true,
                'gallery' => $gallery,
                'image_count' => $imageCount,
                'can_upload' => $imageCount < 6,
                'remaining_slots' => 6 - $imageCount,
                'is_complete' => $imageCount === 6
            ]
        );
    }

    public function getGalleryStatus($user_id)
    {
        $user = User::find($user_id);
        if (!$user) {
            return response()->json(
                ['status' => false, 'message' => 'User not found'],
                404
            );
        }

        $gallery = Gallery::where('user_id', $user_id)->get();
        $imageCount = $gallery->count();

        return response()->json(
            [
                'status' => true,
                'user_id' => $user_id,
                'image_count' => $imageCount,
                'can_upload' => $imageCount < 6,
                'remaining_slots' => 6 - $imageCount,
                'is_complete' => $imageCount === 6,
                'message' => $imageCount === 6 ? 'Gallery is complete with 6 images' : "Gallery has {$imageCount}/6 images"
            ]
        );
    }

    public function userEducationSave(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'institute' => 'required|string',
                'course' => 'nullable|string',
                'year' => 'required',
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

        DB::table('user_educations')
            ->where('user_id', $request->user_id)
            ->update(['status' => 0]);

        $data = [
            'user_id' => $request->user_id,
            'institute' => $request->institute,
            'course' => $request->course,
            'year' => $request->year,
            'status' => 1,
            'updated_at' => now(),
        ];

        $exists = DB::table('user_educations')->where('id', $request->id)->exists();

        if ($exists) {
            DB::table('user_educations')
                ->where('id', $request->id)
                ->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('user_educations')->insert($data);
        }

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Education details saved successfully',
            ],
            200
        );
    }

    public function userEducationGet(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
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

        $education = DB::table('user_educations')
            ->where('user_id', $request->user_id)
            ->get();
        if ($education) {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $education,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'not_found',
                    'message' => 'No education details found for this user.',
                ],
                404
            );
        }
    }

    public function userEducationStatus(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:user_educations,id',
                'user_id' => 'required|exists:users,id',
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

        $education = DB::table('user_educations')
            ->where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->first();

        if (! $education) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Education record not found for this user.',
                ],
                404
            );
        }

        DB::table('user_educations')
            ->where('user_id', $request->user_id)
            ->update(['status' => 0]);

        $updated = DB::table('user_educations')
            ->where('id', $request->id)
            ->update(['status' => 1]);

        if ($updated) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Education status updated successfully.',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to update education status.',
                ],
                500
            );
        }
    }

    public function userEducationDelete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:user_educations,id',
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

        $deleted = DB::table('user_educations')->where('id', $request->id)->delete();

        if ($deleted) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Education record deleted successfully.',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to delete the education record.',
                ],
                500
            );
        }
    }

    public function userJobSave(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
                'title' => 'required|string',
                'company' => 'required|string',
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

        $data = [
            'user_id' => $request->user_id,
            'title' => $request->title,
            'company' => $request->company,
            'updated_at' => now(),
        ];

        $data['status'] = 1;

        DB::table('user_jobs')
            ->where('user_id', $request->user_id)
            ->update(['status' => 0]);

        $exists = DB::table('user_jobs')->where('id', $request->id)->exists();

        if ($exists) {
            DB::table('user_jobs')
                ->where('id', $request->id)
                ->update($data);
        } else {
            $data['created_at'] = now();
            DB::table('user_jobs')->insert($data);
        }

        return response()->json(
            [
                'status' => 'success',
                'message' => 'Job details saved successfully',
            ],
            200
        );
    }

    public function userJobGet(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
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

        $education = DB::table('user_jobs')
            ->where('user_id', $request->user_id)
            ->get();
        if ($education) {
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $education,
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'not_found',
                    'message' => 'No education details found for this user.',
                ],
                404
            );
        }
    }

    public function userJobDelete(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:user_jobs,id',
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

        $deleted = DB::table('user_jobs')->where('id', $request->id)->delete();

        if ($deleted) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Job record deleted successfully.',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to delete the job record.',
                ],
                500
            );
        }
    }

    public function userJobstatus(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'id' => 'required|exists:user_jobs,id',
                'user_id' => 'required|exists:users,id',
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

        $job = DB::table('user_jobs')
            ->where('id', $request->id)
            ->where('user_id', $request->user_id)
            ->first();

        if (! $job) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Job not found for this user.',
                ],
                404
            );
        }

        DB::table('user_jobs')
            ->where('user_id', $request->user_id)
            ->update(['status' => 0]);

        $updated = DB::table('user_jobs')
            ->where('id', $request->id)
            ->update(['status' => 1]);

        if ($updated) {
            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Job status updated successfully.',
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Failed to update job status.',
                ],
                500
            );
        }
    }

    public function deleteProfile(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'user_id' => 'required|exists:users,id',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'error', 'message' => $validator->errors()],
                422
            );
        }

        $user_id = $request->user_id;


        if (auth('api')->id() != $user_id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        try {
            DB::beginTransaction();

            Message::where('receiver_id', $user_id)->orWhere('sender_id', $user_id)->delete();
            $deleted = User::where('id', $user_id)->delete();

            if ($deleted) {
                DB::commit();
                return response()->json(['status' => 'success', 'message' => 'Account deleted successfully'], 200);
            } else {
                DB::rollback();
                return response()->json(['status' => 'error', 'message' => 'Failed to delete account'], 500);
            }
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json(['status' => 'error', 'message' => 'Server error'], 500);
        }
    }

    public function blockUser(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required',
                'pre_user_id' => 'required',
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

        $alreadyBlocked = DB::table('block_user')
            ->where('user_id', $request->user_id)
            ->where('pre_user_id', $request->pre_user_id)
            ->exists();

        if ($alreadyBlocked) {
            return response()->json(
                [
                    'message' => 'User already blocked',
                    'status' => false,
                ],
                409
            );
        }

        $data = [
            'user_id' => $request->user_id,
            'pre_user_id' => $request->pre_user_id,
        ];

        $insert = DB::table('block_user')->insert($data);

        if (! $insert) {
            return response()->json(
                [
                    'message' => 'Invalid User Details',
                    'status' => false,
                ],
                500
            );
        }

        return response()->json(
            [
                'message' => 'Success',
                'status' => true,
            ],
            200
        );
    }

    public function reportUser(Request $request)
    {

        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required',
                'pre_user_id' => 'required',
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

        $alreadyBlocked = DB::table('report_user')
            ->where('user_id', $request->user_id)
            ->where('pre_user_id', $request->pre_user_id)
            ->exists();

        if ($alreadyBlocked) {
            return response()->json(
                [
                    'message' => 'User already reported list',
                    'status' => false,
                ],
                409
            );
        }

        $data = [
            'user_id' => $request->user_id,
            'pre_user_id' => $request->pre_user_id,
            'remark' => $request->remark,
        ];

        $insert = DB::table('report_user')->insert($data);

        if (! $insert) {
            return response()->json(
                [
                    'message' => 'Invalid User Details',
                    'status' => false,
                ],
                500
            );
        }

        return response()->json(
            [
                'message' => 'Success',
                'status' => true,
            ],
            200
        );
    }

    public function recomentedUser(Request $request)
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

        $user = User::find($request->user_id);

        $fieldsToCompare = [
            'gender_id',
            'height_id',
            'language',
            'looking_for',
            'age',
        ];

        $users = User::where('id', '!=', $user->id)->get();

        $matchedUsers = [];

        foreach ($users as $otherUser) {
            $matchCount = 0;
            $totalCount = count($fieldsToCompare);

            foreach ($fieldsToCompare as $field) {
                if ($field === 'looking_for') {
                    $userLookingFor = is_string($user->looking_for)
                        ? json_decode($user->looking_for, true)
                        : $user->looking_for;

                    $otherUserLookingFor = is_string($otherUser->looking_for)
                        ? json_decode($otherUser->looking_for, true)
                        : $otherUser->looking_for;

                    if (is_array($userLookingFor) && is_array($otherUserLookingFor)) {
                        $common = array_intersect($userLookingFor, $otherUserLookingFor);
                        if (! empty($common)) {
                            $matchCount++;
                        }
                    }
                } else {
                    if ($user->$field === $otherUser->$field && $user->$field !== null) {
                        $matchCount++;
                    }
                }
            }
            $percentage = ($totalCount > 0) ? ($matchCount / $totalCount) * 100 : 0;

            if ($percentage >= 70 && $percentage <= 100) {
                $galleryImage = Gallery::where('user_id', $otherUser->id)->first();
                $matchedUsers[] = [
                    'user' => $otherUser,
                    'match_percentage' => round($percentage, 2),
                    'gallery_image' => $galleryImage ? $galleryImage->image_path : null,
                ];
            }
        }

        return response()->json(
            [
                'status' => 'success',
                'recomended' => $matchedUsers,
            ]
        );
    }
}
