<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\MatchUser;
use DB;
use Illuminate\Http\Request;
use Validator;
use App\Services\FirebaseService;
use App\Events\MessageSent;

class ChatController extends Controller
{
    protected $firebaseService;

    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    public function sendMessage(Request $request)
    {
        $params = $request->all();
        $validator = Validator::make(
            $params,
            [
                'message' => 'nullable|string',
                'sender_id' => 'required|integer',
                'receiver_id' => 'required|integer',
                'file' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp3,wav|max:2048',
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

        $messageData = [
            'sender_id' => $params['sender_id'],
            'receiver_id' => $params['receiver_id'],
            'message' => $params['message'] ?? null,
            'created_at' => now()->toIso8601String(),
            'timestamp' => now()->timestamp,
        ];

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileType = $file->getMimeType();
            $type = str_contains($fileType, 'image') ? 'image' : (str_contains($fileType, 'audio') ? 'audio' : 'file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads');
            $file->move($destinationPath, $fileName);
            $messageData['file_path'] = 'uploads/' . $fileName;
            $messageData['file_type'] = $type;
        }

        $existingMessages = $this->firebaseService->getAllMessages();
        $hasPreviousMessages = collect($existingMessages)->filter(function ($msg) use ($params) {
            return ($msg['sender_id'] == $params['sender_id'] && $msg['receiver_id'] == $params['receiver_id']) ||
                   ($msg['sender_id'] == $params['receiver_id'] && $msg['receiver_id'] == $params['sender_id']);
        })->count() > 0;

        if (!$hasPreviousMessages) {
            MatchUser::where('user_id', $params['sender_id'])
                ->where('pre_user_id', $params['receiver_id'])
                ->update(['status' => 2]); // Status 2 = Chat started

            MatchUser::where('user_id', $params['receiver_id'])
                ->where('pre_user_id', $params['sender_id'])
                ->update(['status' => 2]); // Status 2 = Chat started
        }

        $this->firebaseService->sendMessage($messageData);

        return response()->json(
            [
                'status' => 'Success',
                'message' => $messageData,
            ]
        );
    }

    public function getMessages(Request $request)
    {
        $userId = $request->input('sender_id');
        $receiverId = $request->input('receiver_id');

        if (! $userId || ! $receiverId) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Both sender_id and receiver_id are required.',
                ],
                400
            );
        }
        $allMessages = $this->firebaseService->getAllMessages();
        $filteredMessages = collect($allMessages)->filter(
            function ($msg) use ($userId, $receiverId) {
                return
                    ($msg['sender_id'] == $userId && $msg['receiver_id'] == $receiverId)
                    ||
                    ($msg['sender_id'] == $receiverId && $msg['receiver_id'] == $userId);
            }
        )->sortBy('created_at')->values();

        return response()->json(
            [
                'status' => 'success',
                'messages' => $filteredMessages,
            ]
        );
    }

    public function chatlist(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $search = $request->input('search');

            if (! $userId) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'user_id is required.',
                ], 400);
            }

            $allMessages = $this->firebaseService->getAllMessages();
            $allMessages = is_array($allMessages) ? $allMessages : [];
            $userChats = collect();
            $latestMessages = [];

            foreach ($allMessages as $msg) {
                if (!isset($msg['sender_id']) || !isset($msg['receiver_id'])) {
                    continue;
                }
                if ($msg['sender_id'] == $userId) {
                    $otherUserId = $msg['receiver_id'];
                } elseif ($msg['receiver_id'] == $userId) {
                    $otherUserId = $msg['sender_id'];
                } else {
                    continue;
                }
                if (!isset($latestMessages[$otherUserId]) || (isset($msg['timestamp']) && $msg['timestamp'] > $latestMessages[$otherUserId]['timestamp'])) {
                    $latestMessages[$otherUserId] = $msg;
                }
            }

            foreach ($latestMessages as $otherUserId => $msg) {
                $user = \App\Models\User::find($otherUserId);
                $photoUrl = null;
                $fullName = 'Unknown User';
                if ($user) {
                    $fullName = trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''));
                    if (empty($fullName)) {
                        $fullName = $user->name ?? 'Unknown User';
                    }
                    $photoUrl = \DB::table('gallery')->where('user_id', $otherUserId)->orderBy('id')->value('image_path');
                }
                $userChats->push([
                    'user_id' => $otherUserId,
                    'name' => $fullName,
                    'photo_url' => $photoUrl ?? null,
                    'last_message' => $msg['message'] ?? '',
                    'last_message_time' => $msg['created_at'] ?? '',
                ]);
            }

            $userChats = $userChats->sortByDesc('last_message_time')->values();

            return response()->json([
                'status' => 'success',
                'chatlist' => $userChats,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching chat list: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function chatDelete(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'sender_id' => 'required|integer',
                'receiver_id' => 'required|integer',
            ]
        );

        if ($validator->fails()) {
            return response()->json(
                ['status' => 'error', 'message' => $validator->errors()],
                400
            );
        }
        $senderId = $request->input('sender_id');
        $receiverId = $request->input('receiver_id');
        Message::where(
            function ($query) use ($senderId, $receiverId) {
                $query->where('sender_id', $senderId)
                    ->where('receiver_id', $receiverId);
            }
        )
            ->orWhere(
                function ($query) use ($senderId, $receiverId) {
                    $query->where('sender_id', $receiverId)
                        ->where('receiver_id', $senderId);
                }
            )
            ->delete();

        return response()->json(
            ['status' => 'success', 'message' => 'Chat deleted successfully']
        );
    }
}
