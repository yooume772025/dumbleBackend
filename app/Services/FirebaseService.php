<?php

namespace App\Services;

use Kreait\Firebase\Factory;

class FirebaseService
{
    protected $firebase;

    public function __construct()
    {
        try {
            $this->firebase = (new Factory())
                ->withServiceAccount(
                    storage_path('secure/dumble-c7a8a-firebase-adminsdk-fbsvc-82b81cf3db.json')
                )
                ->withDatabaseUri(
                    'https://your-actual-firebase-project.firebaseio.com'
                )
                ->createDatabase();
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function sendMessage($message)
    {
        $database = $this->firebase;
        $newMessageRef = $database->getReference('messages')->push($message);

        return $newMessageRef->getKey();
    }

    public function getAllMessages()
    {
        $database = $this->firebase;
        $messages = $database->getReference('messages')->getValue();

        return $messages ?? [];
    }

    public function deleteChatMessages($senderId, $receiverId)
    {
        $chatPath1 = "chats/{$senderId}_{$receiverId}";
        $chatPath2 = "chats/{$receiverId}_{$senderId}";

        $this->firebase->getReference($chatPath1)->remove();
        $this->firebase->getReference($chatPath2)->remove();
    }
}
