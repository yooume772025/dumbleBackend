<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\CaptionController;
use App\Http\Controllers\Api\ChangePassController;
use App\Http\Controllers\Api\ChatController;
use App\Http\Controllers\Api\CountryController;
use App\Http\Controllers\Api\GenderController;
use App\Http\Controllers\Api\HeightController;
use App\Http\Controllers\Api\JobController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\LikeController;
use App\Http\Controllers\Api\LocationController;
use App\Http\Controllers\Api\MatchuserController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PronounceController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\RelationController;
use App\Http\Controllers\Api\ServiceController;
use App\Http\Controllers\Api\SettingController as ApiSettingController;
use App\Http\Controllers\Api\SportlightController;
use App\Http\Controllers\Api\SubGenderController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\SuperSwipeController;
use App\Http\Controllers\Api\SubServiceController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::get(
    '/verify/code', function (Request $request) {
        return response()->json(
            [
            'success' => true,
            'message' => 'Valid APP key',
            ]
        );
    }
)->middleware('check.api.key');

Route::controller(SportlightController::class)->group(
    function () {
        Route::get('sportlights', 'sportlights');
    }
);

Route::controller(SuperSwipeController::class)->group(
    function () {
        Route::get('superswipe', 'superswipes');
    }
);

Route::get('country', [CountryController::class, 'country']);
Route::get(
    'sub/gender/{genderID}/list',
    [SubGenderController::class, 'subGenderList']
);
Route::get(
    'gender/list',
    [GenderController::class, 'genderList']
)->name('genderList');
Route::get(
    'Height/list',
    [HeightController::class, 'heightList']
);
Route::get('Relationship/list', [RelationController::class, 'relationshipList']);
Route::get('Service/list', [ServiceController::class, 'serviceList']);
Route::get('sub/Service/list', [SubServiceController::class, 'suberviceList']);
Route::get(
    'sub/service/{serviceID}/list',
    [SubServiceController::class, 'subservicelist']
);
Route::get('Caption/list', [CaptionController::class, 'CaptionList']);
Route::get('Language/list', [LanguageController::class, 'languageList']);

Route::get('About/list', [AboutController::class, 'AboutList']);

Route::get('Cities/list', [LocationController::class, 'locationList']);
Route::get('hometowns', [LocationController::class, 'hometowns']);
Route::get('years', [LocationController::class, 'years']);
Route::get('Pronounce/list', [PronounceController::class, 'pronounceList']);
Route::get('Workout/list', [WorkoutController::class, 'workoutList']);
Route::get('job/list', [JobController::class, 'jobList']);
Route::get('looking/for/list', [JobController::class, 'lookingList'])->name('lookingList');
Route::get('Education/list', [JobController::class, 'educationList']);
Route::get('Exercise/list', [JobController::class, 'exerciseList']);
Route::get('Subscription/list', [SubscriptionController::class, 'subscriptionList']);
Route::get('user/subscription', [SubscriptionController::class, 'userSubscription'])->middleware('jwt.api');
Route::post(
    '/android-subscribe',
    [
        SubscriptionController::class,
        'googleSubscribe',
    ]
)->middleware('jwt.api');
Route::any(
    'user/subscription/get',
    [
        SubscriptionController::class,
        'userSubscriptionGet',
    ]
)->middleware('jwt.api');
Route::get('terms', [ApiSettingController::class, 'terms'])->name('terms');
Route::get('sociallogins', [ApiSettingController::class, 'sociallogins']);
Route::get('admob', [ApiSettingController::class, 'admob']);
Route::get('privacy', [ApiSettingController::class, 'privacy'])->name('privacy');
Route::get('faqs', [ApiSettingController::class, 'faqs'])->name('faqs');


Route::get('/test-twilio-config', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Twilio configuration test endpoint',
        'config' => [
            'sid' => config('services.twilio.sid') ? 'Set' : 'Not Set',
            'token' => config('services.twilio.token') ? 'Set' : 'Not Set',
            'from' => config('services.twilio.from') ? 'Set' : 'Not Set',
            'demo_mode' => config('services.twilio.demo_mode') ? 'Enabled' : 'Disabled',
        ]
    ]);
})->middleware('jwt.api');
Route::get(
    'contact/us',
    [
        ApiSettingController::class,
        'contactUs',
    ]
)->name('contactus');
Route::get('Cookies', [ApiSettingController::class, 'cookies'])->name('Cookies');
Route::get('social/settings', [ApiSettingController::class, 'socialSetting']);
Route::any('change/password', [ChangePassController::class, 'ChangePass']);
Route::get('password/reset/{token}', [ChangePassController::class, 'showResetForm']);
Route::post('refresh-token', [RegisterController::class, 'refresh']);
Route::any('user/register', [RegisterController::class, 'userRegister']);
Route::any('verify', [RegisterController::class, 'verifyOTP']);
Route::any('/device-info', [RegisterController::class, 'deviceInfo']);
Route::get('google/login', [RegisterController::class, 'googleLogin']);
Route::get('facebook/login', [RegisterController::class, 'facebookLogin']);
Route::any('Complete/profile', [RegisterController::class, 'completeProfile'])->middleware('jwt.api');
Route::any('User/Details', [RegisterController::class, 'userDetails'])->middleware('jwt.api');
Route::get('User/list', [RegisterController::class, 'userList'])->middleware('jwt.api');
Route::get('User/list/tab', [RegisterController::class, 'userListtab'])->middleware('jwt.api');
Route::get(
    'facebook/callback',
    [RegisterController::class, 'handleFacebookCallback']
);

Route::post('/user/upload-gallery', [UserController::class, 'uploadUserGallery'])->middleware('jwt.api');
Route::any('/user/update-gallery', [UserController::class, 'updateUserGallery'])->middleware('jwt.api');
Route::any('/user/delete-gallery', [UserController::class, 'deleteUserGallery'])->middleware('jwt.api');
Route::post('/user/replace-gallery-image', [UserController::class, 'replaceGalleryImage'])->middleware('jwt.api');
Route::get('/user/gallery/{user_id}', [UserController::class, 'getUserGallery'])->middleware('jwt.api');
Route::get('/user/gallery-status/{user_id}', [UserController::class, 'getGalleryStatus'])->middleware('jwt.api');
Route::post('user/details/save', [RegisterController::class, 'userDetailsSave'])->middleware('jwt.api');
Route::post('user/education/save', [UserController::class, 'userEducationSave'])->middleware('jwt.api');
Route::get('user/education/get', [UserController::class, 'userEducationGet'])->middleware('jwt.api');
Route::get('user/education/delete', [UserController::class, 'userEducationDelete'])->middleware('jwt.api');
Route::get('user/education/status', [UserController::class, 'userEducationStatus'])->middleware('jwt.api');
Route::post('user/job/save', [UserController::class, 'userJobSave'])->middleware('jwt.api');
Route::get('user/jobs/get', [UserController::class, 'userJobGet'])->middleware('jwt.api');
Route::get('user/job/delete', [UserController::class, 'userJobDelete'])->middleware('jwt.api');
Route::get('user/job/status', [UserController::class, 'userJobstatus'])->middleware('jwt.api');

Route::any('Delete/account', [UserController::class, 'deleteProfile'])->middleware('jwt.api');
Route::any('Block/user', [UserController::class, 'blockUser'])->middleware('jwt.api');
Route::any('Report/user', [UserController::class, 'reportUser'])->middleware('jwt.api');
Route::any('recomented/user', [UserController::class, 'recomentedUser'])->middleware('jwt.api');

Route::any('user/match', [MatchuserController::class, 'matchuser'])->middleware('jwt.api');
Route::get('user/unmatch/list', [MatchuserController::class, 'unmatchingList'])->middleware('jwt.api');
Route::any('user/like', [LikeController::class, 'likeuser'])->middleware('jwt.api');
Route::any('user/unany/list', [LikeController::class, 'unanyingList'])->middleware('jwt.api');
Route::get('like/you', [LikeController::class, 'likeYou'])->middleware('jwt.api');
Route::get('like/me', [LikeController::class, 'likeMe'])->middleware('jwt.api');
Route::any('apply/filter', [RegisterController::class, 'applyFilter'])->middleware('jwt.api');
Route::any('get/filter', [RegisterController::class, 'getFilter'])->middleware('jwt.api');
Route::post('/send-message', [ChatController::class, 'sendMessage'])->middleware('jwt.api');
Route::get('/get-messages', [ChatController::class, 'getMessages'])->middleware('jwt.api');
Route::get('/chat/list', [ChatController::class, 'chatlist'])->middleware('jwt.api');
Route::get('/chat/delete', [ChatController::class, 'chatdelete'])->middleware('jwt.api');
Route::any('Zodiac/Signs', [LikeController::class, 'zodiac'])->middleware('jwt.api');
Route::get('education/labels', [LikeController::class, 'educationLabels'])->middleware('jwt.api');
Route::any('notification', [NotificationController::class, 'notification'])->middleware('jwt.api');
Route::any('notification/save', [NotificationController::class, 'notificationsave'])->middleware('jwt.api');
Route::get('match/user/list', [MatchuserController::class, 'matchinglist'])->middleware('jwt.api');
Route::get('match/profile', [MatchuserController::class, 'matchProfile'])->middleware('jwt.api');
Route::get('Discovery', [MatchuserController::class, 'discovery'])->middleware('jwt.api');
Route::get(
    'remove/match/user/list',
    [
        MatchuserController::class,
        'removeMatchinglist',
    ]
)->middleware('jwt.api');
Route::post('/detect-human-face', [MatchuserController::class, 'detect'])->middleware('jwt.api');
Route::any('unmatching/user', [MatchuserController::class, 'unmatching'])->middleware('jwt.api');
