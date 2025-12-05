<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\CaptionController;
use App\Http\Controllers\ChangePassController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\HeightController;
use App\Http\Controllers\InstallController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PronounceController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\RelationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController as WebSettingController;
use App\Http\Controllers\SubGenderController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\SubServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('license');
Route::post(
    'admin/login',
    [LoginController::class, 'adminlogin']
)->name('admin.login');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/install', [InstallController::class, 'index'])->name('install.index');
Route::post('/install', [InstallController::class, 'install'])->name('install.step');
Route::get('/purchase', [PurchaseController::class, 'index'])->name('purchase.index');
Route::post('/purchase', [PurchaseController::class, 'store'])->name('purchase.store');
Route::get('/install/{any}', function () {
    $appInstalled = filter_var(env('APP_INSTALLED', false), FILTER_VALIDATE_BOOLEAN);
    if ($appInstalled) {
        return redirect()->route('login')->with('error', 'Application is already installed!');
    }
    return redirect()->route('install.index');
})->where('any', '.*');
Route::any(
    'change/password',
    [ChangePassController::class, 'changePass']
)
    ->name('change-password');

Route::middleware(['license', 'auth:admin'])->name('user.')->group(
    function () {

        Route::get('', [UserController::class, 'dashboard'])->name('dashboard');
        Route::get('user', [UserController::class, 'index'])->name('index');
        Route::get('view', [UserController::class, 'userView'])->name('view');
        Route::post('save', [UserController::class, 'save']);
        Route::get('getById', [UserController::class, 'getById']);
        Route::post('update', [UserController::class, 'update']);
        Route::get('profile', [UserController::class, 'profile'])->name('profile');
        Route::post(
            'profile/save',
            [UserController::class, 'profileSave']
        )->name('profile-save');
        Route::get(
            'delete',
            [UserController::class, 'deleteById']
        )
            ->name('deleteById');
        Route::get(
            'ajaxcall',
            [UserController::class, 'ajaxcall']
        )
            ->name('ajaxcall');
        Route::any(
            'suspend-user',
            [UserController::class, 'suspenduser']
        )
            ->name('suspend-user');
        Route::get(
            'userbanned',
            [UserController::class, 'userbanned']
        )
            ->name('userbanned');
        Route::get(
            'reported-user',
            [UserController::class, 'reportedUser']
        )
            ->name('reported-user');
        Route::get(
            'user/ajaxcall',
            [UserController::class, 'reportAjaxcall']
        )
            ->name('reportajaxcall');
        Route::get(
            'userbanned/ajaxcall',
            [UserController::class, 'userbannedAjaxcall']
        )
            ->name('userbanned.ajaxcall');
        Route::get(
            'gender',
            [GenderController::class, 'gender']
        )
            ->name('gender');
        Route::get(
            'gender.ajaxcall',
            [GenderController::class, 'genderAjaxcall']
        )
            ->name('gender.ajaxcall');
        Route::post(
            'gender.save',
            [GenderController::class, 'genderSave']
        )
            ->name('gender-save');
        Route::get(
            'getgender',
            [GenderController::class, 'getgender']
        )
            ->name('getgender');
        Route::post('genderupdate', [GenderController::class, 'genderUpdate'])
            ->name('genderupdate');

        Route::get(
            'country',
            [CountryController::class, 'country']
        )
            ->name('country');
        Route::post(
            'country/save',
            [CountryController::class, 'countrySave']
        )
            ->name('country-save');
        Route::get(
            'country/list',
            [CountryController::class, 'countryList']
        )
            ->name('country-list');
        Route::get(
            'country/fetch',
            [CountryController::class, 'getcountry']
        )
            ->name('getcountry');

        Route::get(
            'sub/gender',
            [SubGenderController::class, 'subgender']
        )
            ->name('sub-gender');
        Route::get(
            'subgender.ajaxcall',
            [SubGenderController::class, 'subgenderAjaxcall']
        )
            ->name('subgender.ajaxcall');
        Route::post(
            'subgender-save',
            [SubGenderController::class, 'subgenderSave']
        )
            ->name('subgender-save');
        Route::get(
            'getsubgender',
            [SubGenderController::class, 'getsubgender']
        )
            ->name('getsubgender');
        Route::post(
            'subgenderupdate',
            [SubGenderController::class, 'subgenderupdate']
        )
            ->name('subgenderupdate');

        Route::get(
            'height',
            [HeightController::class, 'height']
        )
            ->name('height');
        Route::get(
            'height.ajaxcall',
            [HeightController::class, 'heightAjaxcall']
        )
            ->name('height.ajaxcall');
        Route::post(
            'height-save',
            [HeightController::class, 'heightSave']
        )
            ->name('height-save');
        Route::get(
            'getheight',
            [HeightController::class, 'getheight']
        )
            ->name('getheight');
        Route::post(
            'heightupdate',
            [HeightController::class, 'heightupdate']
        )
            ->name('heightupdate');

        Route::get(
            'relation',
            [RelationController::class, 'relation']
        )
            ->name('relation');
        Route::get(
            'relation.ajaxcall',
            [RelationController::class, 'relationAjaxcall']
        )
            ->name('relation.ajaxcall');
        Route::post(
            'relation-save',
            [RelationController::class, 'relationSave']
        )
            ->name('relation-save');
        Route::get(
            'getrelation',
            [RelationController::class, 'getrelation']
        )
            ->name('getrelation');
        Route::any(
            'relationupdate',
            [RelationController::class, 'relationupdate']
        )
            ->name('relationupdate');

        Route::get(
            'service',
            [ServiceController::class, 'service']
        )
            ->name('service');
        Route::get(
            'service.ajaxcall',
            [ServiceController::class, 'serviceAjaxcall']
        )
            ->name('service.ajaxcall');
        Route::post(
            'service-save',
            [ServiceController::class, 'serviceSave']
        )
            ->name('service-save');
        Route::get(
            'getservice',
            [ServiceController::class, 'getservice']
        )
            ->name('getservice');
        Route::any(
            'serviceupdate',
            [ServiceController::class, 'serviceupdate']
        )
            ->name('serviceupdate');

        Route::get(
            'sub-service',
            [SubServiceController::class, 'subService']
        )
            ->name('sub-service');
        Route::get(
            'subservice.ajaxcall',
            [SubServiceController::class, 'subserviceAjaxcall']
        )
            ->name('subservice.ajaxcall');
        Route::post(
            'sub-service-save',
            [SubServiceController::class, 'subServiceSave']
        )
            ->name('sub-service-save');
        Route::get(
            'getsubservice',
            [SubServiceController::class, 'getsubservice']
        )
            ->name('getsubservice');
        Route::post(
            'subserviceupdate',
            [SubServiceController::class, 'subserviceupdate']
        )
            ->name('subserviceupdate');

        Route::get(
            'caption',
            [CaptionController::class, 'caption']
        )
            ->name('caption');
        Route::get(
            'caption.ajaxcall',
            [CaptionController::class, 'captionAjaxCall']
        )
            ->name('caption.ajaxcall');
        Route::post(
            'caption-save',
            [CaptionController::class, 'CaptionSave']
        )
            ->name('caption-save');
        Route::get(
            'getcaption',
            [CaptionController::class, 'getcaption']
        )
            ->name('getcaption');
        Route::post(
            'captionupdate',
            [CaptionController::class, 'captionupdate']
        )
            ->name('captionupdate');

        Route::get(
            'language',
            [LanguageController::class, 'language']
        )
            ->name('language');
        Route::get(
            'language.ajaxcall',
            [LanguageController::class, 'languageAjaxcall']
        )
            ->name('language.ajaxcall');
        Route::post(
            'language-save',
            [LanguageController::class, 'languageSave']
        )
            ->name('language-save');
        Route::get(
            'getlanguage',
            [LanguageController::class, 'getlanguage']
        )
            ->name('getlanguage');
        Route::post(
            'languageupdate',
            [LanguageController::class, 'languageUpdate']
        )
            ->name('languageupdate');

        Route::get('about', [AboutController::class, 'about'])->name('about');
        Route::get(
            'about.ajaxcall',
            [AboutController::class, 'aboutAjaxcall']
        )
            ->name('about.ajaxcall');
        Route::post(
            'about-save',
            [AboutController::class, 'aboutSave']
        )
            ->name('about-save');
        Route::get(
            'getabout',
            [AboutController::class, 'getAbout']
        )
            ->name('getabout');
        Route::post(
            'aboutupdate',
            [AboutController::class, 'aboutUpdate']
        )
            ->name('aboutupdate');

        Route::get(
            'location',
            [LocationController::class, 'location']
        )->name('location');
        Route::get(
            'location.ajaxcall',
            [LocationController::class, 'locationAjaxcall']
        )
            ->name('location.ajaxcall');
        Route::post(
            'location-save',
            [LocationController::class, 'locationSave']
        )
            ->name('location-save');
        Route::get(
            'getlocation',
            [LocationController::class, 'getLocation']
        )
            ->name('getlocation');
        Route::post(
            'locationupdate',
            [LocationController::class, 'locationUpdate']
        )
            ->name('locationupdate');

        Route::get(
            'pronounce',
            [PronounceController::class, 'pronounce']
        )
            ->name('pronounce');
        Route::get(
            'pronounce.ajaxcall',
            [PronounceController::class, 'pronounceAjaxcall']
        )
            ->name('pronounce.ajaxcall');
        Route::any(
            'pronounce-save',
            [PronounceController::class, 'pronounceSave']
        )
            ->name('pronounce-save');
        Route::get(
            'getpronounce',
            [PronounceController::class, 'getpronounce']
        )
            ->name('getpronounce');
        Route::any(
            'Pronounceupdate',
            [PronounceController::class, 'pronounceUpdate']
        )
            ->name('Pronounceupdate');

        Route::get(
            'work-out',
            [WorkoutController::class, 'workout']
        )
            ->name('work-out');
        Route::get(
            'workout.ajaxcall',
            [WorkoutController::class, 'workoutAjaxcall']
        )
            ->name('workout.ajaxcall');
        Route::any(
            'workout-save',
            [WorkoutController::class, 'workOutSave']
        )
            ->name('workout-save');
        Route::get(
            'getworkout',
            [WorkoutController::class, 'getworkout']
        )
            ->name('getworkout');
        Route::any(
            'workoutupdate',
            [WorkoutController::class, 'workoutupdate']
        )
            ->name('workoutupdate');

        Route::get('job', [JobController::class, 'job'])->name('job');
        Route::get(
            'job.ajaxcall',
            [JobController::class, 'jobAjaxcall']
        )
            ->name('job.ajaxcall');
        Route::any(
            'job-save',
            [JobController::class, 'jobSave']
        )
            ->name('job-save');
        Route::get(
            'getjob',
            [JobController::class, 'getjob']
        )
            ->name('getjob');
        Route::any(
            'jobupdate',
            [JobController::class, 'jobupdate']
        )
            ->name('jobupdate');

        Route::get(
            'education',
            [EducationController::class, 'education']
        )
            ->name('education');
        Route::get(
            'education.ajaxcall',
            [EducationController::class, 'educationAjaxcall']
        )
            ->name('education.ajaxcall');
        Route::any(
            'education-save',
            [EducationController::class, 'educationSave']
        )
            ->name('education-save');
        Route::get(
            'geteducation',
            [EducationController::class, 'geteducation']
        )->name('geteducation');
        Route::any(
            'educationupdate',
            [EducationController::class, 'educationUpdate']
        )->name('educationupdate');

        Route::get(
            'exercise',
            [ExerciseController::class, 'exercise']
        )
            ->name('exercise');
        Route::get(
            'exercise.ajaxcall',
            [ExerciseController::class, 'exerciseAjaxcall']
        )
            ->name('exercise.ajaxcall');
        Route::any(
            'exercise-save',
            [ExerciseController::class, 'exerciseSave']
        )
            ->name('exercise-save');
        Route::get(
            'getexercise',
            [ExerciseController::class, 'getexercise']
        )
            ->name('getexercise');
        Route::any(
            'exerciseupdate',
            [ExerciseController::class, 'exerciseupdate']
        )
            ->name('exerciseupdate');

        Route::get(
            'subscription',
            [SubscriptionController::class, 'subscription']
        )
            ->name('subscription');
        Route::get(
            'subscription.ajaxcall',
            [SubscriptionController::class, 'subscriptionAjaxcall']
        )
            ->name('subscription.ajaxcall');
        Route::any(
            'subscription-save',
            [SubscriptionController::class, 'subscriptionSave']
        )
            ->name('subscription-save');
        Route::get(
            'getsubscription',
            [SubscriptionController::class, 'getsubscription']
        )
            ->name('getsubscription');
        Route::any(
            'subscriptionupdate',
            [SubscriptionController::class, 'subscriptionupdate']
        )
            ->name('subscriptionupdate');
        Route::get(
            'user/subscription',
            [SubscriptionController::class, 'uerSubscription']
        )
            ->name('user-subscription');
        Route::get(
            'user/subscription/ajax',
            [SubscriptionController::class, 'uerSubscriptionAjaxcall']
        )
            ->name('user-subscription-ajaxcall');
        route::get(
            'settings',
            [WebSettingController::class, 'settings']
        )
            ->name('settings');
        route::get(
            'info',
            [WebSettingController::class, 'info']
        )
            ->name('info');
        route::get(
            'add/page',
            [WebSettingController::class, 'addPage']
        )
            ->name('add-page');
        route::post(
            'page/save',
            [WebSettingController::class, 'pageSave']
        )->name('page-save');
        route::get(
            'page/list',
            [WebSettingController::class, 'pageList']
        )
            ->name('page-list');
        route::get(
            'page/edit',
            [WebSettingController::class, 'pageedit']
        )
            ->name('page-edit');
        route::post(
            'page/update',
            [WebSettingController::class, 'pageUpdate']
        )
            ->name('page-update');
        route::delete(
            'page/delete',
            [WebSettingController::class, 'pageDelete']
        )
            ->name('page-delete');
        route::get(
            'google-addmob',
            [WebSettingController::class, 'googleAddmob']
        )
            ->name('google-addmob');
        route::post(
            'googleadd/save',
            [WebSettingController::class, 'googleAddSave']
        )
            ->name('googleadd-save');
        route::get(
            'panel-setting',
            [WebSettingController::class, 'panelSetting']
        )
            ->name('panel-setting');
        route::post(
            'webpanel-save',
            [WebSettingController::class, 'webPanelSave']
        )
            ->name('webpanel-save');
        route::get(
            'web-settings',
            [WebSettingController::class, 'webSetting']
        )
            ->name('web-settings');
        route::post(
            'webupdate',
            [WebSettingController::class, 'webupdate']
        )
            ->name('webupdate');
        route::get(
            'sms-settings',
            [WebSettingController::class, 'smsSettings']
        )
            ->name('sms-settings');
        route::post(
            'sms-update',
            [WebSettingController::class, 'smsUpdate']
        )
            ->name('sms-update');
        route::get(
            'general-settings',
            [WebSettingController::class, 'generalSetting']
        )
            ->name('general-settings');
        route::get(
            'social-settings',
            [WebSettingController::class, 'socialSetting']
        )
            ->name('social-settings');
        route::get(
            'social-login-add',
            [WebSettingController::class, 'socialSettingadd']
        )
            ->name('social-login-add');
        route::post(
            'socialsetting-save',
            [WebSettingController::class, 'socialSettingSave']
        )
            ->name('socialsetting-save');
        route::get(
            'sociallogin-list',
            [WebSettingController::class, 'socialSettingList']
        )
            ->name('sociallogin-list');
        route::get(
            'sociallogin-delete',
            [WebSettingController::class, 'socialSettingDelete']
        )
            ->name('sociallogin-delete');
        route::post(
            'likes-update',
            [WebSettingController::class, 'likeUpdate']
        )
            ->name('likes-update');
    }
);

Route::get(
    'facebook',
    [App\Http\Controllers\Api\RegisterController::class, 'redirectToFacebook']
)
    ->name('facebook');
Route::get(
    'facebook/callback',
    [App\Http\Controllers\Api\RegisterController::class, 'handleFacebookCallback']
)
    ->name('handleFacebookCallback');
