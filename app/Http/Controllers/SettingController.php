<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Sociallogin;
use DB;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function settings()
    {
        return view('settings.index');
    }

    public function info()
    {
        return view('settings.info');
    }

    public function addPage()
    {
        return view('settings.add_page');
    }

    public function pageSave(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
            ]
        );

        $page = new Setting();
        $page->name = $request->name;
        $page->description = $request->description;
        $page->save();

        return redirect()->back()->with('success', 'Page added successfully!');
    }

    public function pageList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchArr = $request->get('search');
        $searchValue = $searchArr['value'] ?? '';
        $orderArr = $request->get('order');
        $columnsArr = $request->get('columns');
        $columnIndex = $orderArr[0]['column'] ?? 0;
        $columnName = $columnsArr[$columnIndex]['data'] ?? 'id';
        $columnSortOrder = $orderArr[0]['dir'] ?? 'desc';

        $data = Setting::query();

        if (! empty($searchValue)) {
            $data->where('name', 'like', '%' . $searchValue . '%');
        }

        $totalRecordsWithFilter = $data->count();
        $totalRecords = $totalRecordsWithFilter;
        $list = $data->skip($start)->take($length)->orderBy($columnName, $columnSortOrder)->get();

        $dataArr = [];
        foreach ($list as $key => $record) {
            $id = $record->id;
            $action = '<a class="dropdown-items update" href="' . route('user.page-edit', ['id' => $id]) . '" 
            
            data-id="' . $id . '"><i class="bi bi-pencil-fill"></i></a>';
            $action .= '<a class="dropdown-items delete" href="javascript:void(0);" 
            
            data-id="' . $id . '"><i class="bi bi-trash-fill"></i></a>';

            $dataArr[] = [
                'id' => ++$start,
                'name' => $record->name,
                'date' => date('d-m-Y h:i a', strtotime($record->created_at)),
                'action' => $action,
            ];
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordsWithFilter,
            'aaData' => $dataArr,
        ];

        echo json_encode($response);
        exit();
    }

    public function pageedit(Request $request)
    {
        $id = $request->get('id');
        $page = Setting::find($id);

        return view('settings.edit_page', compact('page'));
    }

    public function pageUpdate(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'required|string',
            ]
        );

        $page = Setting::find($request->id);
        if ($page) {
            $page->name = $request->name;
            $page->description = $request->description;
            $page->save();

            return redirect()->back()->with('success', 'Page updated successfully!');
        }

        return redirect()->back()->with('error', 'Page not found!');
    }

    public function pageDelete(Request $request)
    {
        $id = $request->get('id');
        $page = Setting::find($id);
        if ($page) {
            $page->delete();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Page deleted successfully!',
                ]
            );
        }

        return response()->json(
            [
                'success' => false,
                'message' => 'Page not found!',
            ]
        );
    }

    public function googleAddmob()
    {
        return view('settings.google_addmob');
    }

    public function googleAddSave(Request $request)
    {
        $request->validate(
            [
                'name' => 'nullable|string|max:255',
                'app_id' => 'required|string',
                'banner_unit_id' => 'required|string',
                'interstitial_unit_id' => 'required|string',
                'rewarded_unit_id' => 'required|string',
            ]
        );

        $data = [
            'name' => $request->name ?? 'Google AdMob',
            'app_id' => $request->app_id,
            'banner_unit_id' => $request->banner_unit_id,
            'interstitial_unit_id' => $request->interstitial_unit_id,
            'rewarded_unit_id' => $request->rewarded_unit_id,
            'device' => $request->device,
        ];

        DB::table('social_setting')->updateOrInsert(
            ['name' => 'google_addmob'],
            $data
        );

        return redirect()->back()->with('success', 'Google AdMob settings saved successfully!');
    }

    public function panelSetting()
    {
        return view('settings.panel_setting');
    }

    public function webPanelSave(Request $request)
    {
        $data = [];

        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $imageName = time() . '_logo.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/logo'), $imageName);
            $data['logo'] = 'uploads/logo/' . $imageName;
        }

        if ($request->hasFile('favicon')) {
            $image = $request->file('favicon');
            $imageName = time() . '_favicon.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/favicon'), $imageName);
            $data['favicon'] = 'uploads/favicon/' . $imageName;
        }

        if (! empty($data)) {
            DB::table('web_settings')->updateOrInsert(
                ['id' => 1],
                $data
            );
        }

        return redirect()->back()->with('success', 'Saved successfully!');
    }

    public function webSetting()
    {
        return view('settings.web-setting');
    }

    public function webupdate(Request $request)
    {
        $this->setEnv(
            [
                'APP_NAME' => $request->name,
                'APP_URL' => $request->url,
            ]
        );

        return back()->with('success', 'Environment updated!');
    }

    public function smsSettings()
    {
        return view('settings.sms-setting');
    }

    public function smsUpdate(Request $request)
    {
        $this->setEnv(
            [
                'TWILIO_SID' => $request->twilwo_sid,
                'TWILIO_AUTH_TOKEN' => $request->twileo_auth,
                'TWILIO_FROM' => $request->twileo_phone,
                'TWILIO_DEMO_MODE' => $request->has('twilio_demo_mode') ? 'true' : 'false',
            ]
        );

        return back()->with('success', 'Environment updated!');
    }

    private function setEnv(array $values)
    {
        $envPath = base_path('.env');
        if (file_exists($envPath)) {
            $envContent = file_get_contents($envPath);
            foreach ($values as $key => $value) {
                if (strpos($envContent, $key . '=') !== false) {
                    $envContent = preg_replace("/^{$key}=.*$/m", "{$key}=\"{$value}\"", $envContent);
                } else {
                    $envContent .= "\n{$key}=\"{$value}\"";
                }
            }
            file_put_contents($envPath, $envContent);
        }
    }

    public function generalSetting()
    {
        return view('settings.general-setting');
    }

    public function likeUpdate(Request $request)
    {
        DB::table('general_setting')->updateOrInsert(
            ['name' => 'like_setting'],
            [
                'like_limit' => $request->like_limit,
                'duration' => $request->like_per_day,
                'updated_at' => now(),
            ]
        );

        return back()->with('success', 'Like settings updated successfully.');
    }

    public function socialSetting()
    {
        return view('settings.social-setting');
    }

    public function socialSettingadd()
    {
        return view('settings.social-add');
    }

    public function socialSettingSave(Request $request)
    {
        Sociallogin::updateOrCreate(
            ['name' => $request->name],
            [
                'app_key' => $request->app_key,
                'app_secret' => $request->app_secret,
            ]
        );

        return back()->with('success', 'Like settings updated successfully.');
    }

    public function socialSettingList(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $searchArr = $request->get('search');
        $searchValue = $searchArr['value'] ?? '';
        $orderArr = $request->get('order');
        $columnsArr = $request->get('columns');
        $columnIndex = $orderArr[0]['column'] ?? 0;
        $columnName = $columnsArr[$columnIndex]['data'] ?? 'id';
        $columnSortOrder = $orderArr[0]['dir'] ?? 'desc';

        $data = Sociallogin::query();

        if (! empty($searchValue)) {
            $data->where('name', 'like', '%' . $searchValue . '%');
        }

        $totalRecordsWithFilter = $data->count();
        $totalRecords = $totalRecordsWithFilter;
        $list = $data->skip($start)->take($length)->orderBy($columnName, $columnSortOrder)->get();

        $dataArr = [];
        foreach ($list as $key => $record) {
            $id = $record->id;
            $action = '<a class="dropdown-items update" href="' . route('user.social-login-add') . '" 
            
            data-id="' . $id . '"><i class="bi bi-pencil-fill"></i></a>';
            $action .= '<a class="dropdown-items delete" href="javascript:void(0);" 
            
            data-id="' . $id . '"><i class="bi bi-trash-fill"></i></a>';

            $dataArr[] = [
                'id' => ++$start,
                'name' => $record->name,
                'app_key' => $record->app_key,
                'app_secret' => $record->app_secret,
                'date' => date('d-m-Y h:i a', strtotime($record->created_at)),
                'action' => $action,
            ];
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordsWithFilter,
            'aaData' => $dataArr,
        ];

        echo json_encode($response);
        exit();
    }

    public function socialSettingDelete(Request $request)
    {
        $id = $request->get('id');
        $page = Sociallogin::find($id);
        if ($page) {
            $page->delete();

            return response()->json(
                [
                    'status' => 'success',
                    'message' => 'Deleted successfully!',
                ]
            );
        }

        return response()->json(
            [
                'success' => false,
                'message' => 'Record not found!',
            ]
        );
    }
}
