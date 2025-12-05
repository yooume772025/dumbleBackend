<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\LikeUser;
use App\Models\MatchUser;
use App\Models\Transacation;
use App\Models\User;
use App\Services\AdMobService;
use Auth;
use Carbon\Carbon;
use DB;
use Hash;
use Illuminate\Http\Request;
use Validator;

class UserController extends Controller
{
    public function dashboard(AdMobService $adMobService)
    {
        // Auto-clear cache in development
        if (app()->environment('local') || app()->environment('development')) {
            try {
                \Artisan::call('cache:clear');
                \Artisan::call('config:clear');
                \Artisan::call('view:clear');
                \Artisan::call('route:clear');
            } catch (\Exception $e) {
                // Silently fail if cache clearing fails
            }
        }
        
        try {
            $user = User::count();
            $activeuser = User::where('status', 1)->count();
            $inactiveuser = User::where('status', 0)->count();
            try {
                $verifyuser = User::where('verified', '1')->orWhere('verified', 1)->orWhere('verified', true)->count();
            } catch (\Exception $e) {
                $verifyuser = 0;
            }
            $totalrevenue = Transacation::sum('amount') ?? 0;
            $currentMonthRevenue = Transacation::whereMonth(
                'created_at',
                Carbon::now()->month
            )
                ->whereYear('created_at', Carbon::now()->year)
                ->sum('amount') ?? 0;

            $revenueData = $adMobService->getAdMobReport();

            if (is_array($revenueData)) {
                $revenueData = array_sum(array_column($revenueData, 'earnings'));
            } else {
                $revenueData = (float) $revenueData;
            }
        } catch (\Exception $e) {
            $user = 0;
            $activeuser = 0;
            $inactiveuser = 0;
            $verifyuser = 0;
            $totalrevenue = 0;
            $currentMonthRevenue = 0;
            $revenueData = 0;
        }

        return view(
            'home',
            compact(
                'user',
                'activeuser',
                'inactiveuser',
                'totalrevenue',
                'currentMonthRevenue',
                'revenueData',
                'verifyuser'
            )
        );
    }

    public function index()
    {
        return view('user.index');
    }

    public function save(Request $request)
    {
        try {
            if ($request->isMethod('post')) {
                $params = $request->all();
                $messages = [
                    'max' => 'Name should not be greater than 50 characters.',
                ];
                $validator = Validator::make(
                    $params,
                    [
                        'name' => 'required|max:50',
                        'email' => 'required|email|unique:users,email',
                    ],
                    $messages
                );

                if ($validator->fails()) {
                    return response()->json(
                        ['status' => 'errors', 'message' => $validator->errors()]
                    );
                }

                $params = [
                    'name' => $request->name,
                    'username' => $request->user_id,
                    'mobile' => $request->mobile,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                ];

                $user = User::create($params);

                if ($user) {
                    return response()->json(['status' => 'success']);
                }

                return response()->json(
                    ['status' => 'error', 'error' => 'Something Wrong']
                );
            }

            return redirect('home')->with('error', 'Not valid');
        } catch (\Throwable $e) {
            $error = $e->getMessage() . ', File Path = ' . $e->getFile() . ',
            Line Number = ' . $e->getLine();

            return response()->json(
                ['status' => 'exceptionError', 'error' => $error]
            );
        }
    }

    public function update(Request $request)
    {
        try {
            $params = $request->all();
            $messages = [
                'max' => 'Name should not be greater than 50 characters.',
            ];
            $validator = Validator::make(
                $params,
                [
                    'name' => 'required|max:50',
                ],
                $messages
            );

            if ($validator->fails()) {
                return response()->json(
                    ['status' => 'errors', 'message' => $validator->errors()]
                );
            }
            $id = $request->id;

            $params = [
                'name' => $request->name,
                'mobile' => $request->mobile,
                'email' => $request->email,
            ];

            $password = $request->password;

            if ($password != null) {
                $params['password'] = Hash::make($request->password);
            }

            $status = User::where('id', $id)->update($params);

            if ($status) {
                return response()->json(
                    ['status' => 'success', 'message' => 'Successfully Update.']
                );
            }

            return response()->json(
                ['status' => 'error',
                    'message' => 'Something went wrong please try again.',
                ]
            );
        } catch (\Throwable $e) {
            $error = $e->getMessage() . ', File Path
            = ' . $e->getFile() . ', Line Number = ' . $e->getLine();

            return response()->json(
                ['status' => 'exceptionError', 'error' => $error]
            );
        }
    }

    public function deleteById(Request $request)
    {
        try {
            $id = $request->id;

            $status = User::where('id', $id)->delete();

            if ($status) {
                return response()->json(
                    ['status' => 'success', 'message' => 'Successfully Delete.']
                );
            }

            return response()->json(
                ['status' => 'error',
                    'message' => 'Something went wrong please try again.',
                ]
            );
        } catch (\Throwable $e) {
            $error = $e->getMessage() . ', File Path = ' . $e->getFile() . ',
            Line Number = ' . $e->getLine();

            return response()->json(
                ['status' => 'exceptionError', 'error' => $error]
            );
        }
    }

    public function getById(Request $request)
    {
        $id = $request->id;
        $User = User::find($id);
        if ($User == null) {
            return response()->json(
                ['status' => 'error', 'message' => 'Record not found.']
            );
        }

        return response()->json(['status' => 'success', 'data' => $User]);
    }

    public function ajaxcall(Request $request)
    {

        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length');

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $records = User::select('users.*')
            ->where('id', '!=', 1)
            ->where('status', 1)
            ->skip($start)
            ->take($rowperpage)
            ->orderBy('id', 'desc');

        if ($searchValue != null) {
            $records->where(
                function ($query) use ($searchValue) {
                    $query->where('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('mobile', 'like', '%' . $searchValue . '%');
                }
            );
        }

        $totalRecordswithFilter = $records->count();
        $totalRecords = $totalRecordswithFilter;

        $list = $records->get();

        $data_arr = [];

        foreach ($list as $sno => $record) {
            $id = $record->id;

            $action = '<a class="dropdown-items viewprofile"
            href="' . route('user.view', ['id' => $record->id]) . '"
            data-id="' . $id . '"><i class="nav-icon bi bi-eye-fill"></i></a>';

            $action .= ' <a class="dropdown-items update" href="javascript:void(0);"
            data-id="' . $id . '" ><i class="nav-icon bi bi-pencil-fill"></i></a>';
            $action .= '<a class="dropdown-items delete" href="javascript:void(0);"
            data-id="' . $id . '"><i class="nav-icon bi bi-trash-fill"></i></a>';

            $data_arr[] = [
                'id' => ++$start,
                'user_id' => $record->id,
                'name' => $record->name,
                'gender' => $record->gender_id ?? '',
                'subgender' => $record->sub_gender_id ?? '',
                'height' => $record->height_id ?? '',
                'service' => $record->service_id ?? '',
                'about' => $record->about_me ?? '',
                'relation' => $record->relation_id ?? '',
                'email' => $record->email,
                'mobile' => $record->mobile,
                'date' => date('d-m-Y h:i a', strtotime($record->created_at)),
                'Action' => $action,
            ];
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordswithFilter,
            'aaData' => $data_arr,
        ];

        echo json_encode($response);
        exit;
    }

    public function userView(Request $request)
    {
        $id = $request->id;
        $user = User::find($id);
        $likeuser = LikeUser::where('like_user.pre_user_id', $id)
            ->where('like_user.status', 1)
            ->join('users', 'like_user.user_id', '=', 'users.id')
            ->select('users.*', 'like_user.created_at as liked_at')
            ->get();
        $dislikeuser = LikeUser::where('like_user.pre_user_id', $id)
            ->where('like_user.status', 0)
            ->join('users', 'like_user.user_id', '=', 'users.id')
            ->select('users.*', 'like_user.created_at as disliked_at')
            ->get();
        $gallery = Gallery::where('user_id', $id)->get();
        $matchuser = MatchUser::where('matching_user.pre_user_id', $id)
            ->join('users', 'matching_user.user_id', '=', 'users.id')
            ->select('users.*', 'matching_user.created_at as matched_at')
            ->get();

        return view(
            'user.view',
            compact('user', 'likeuser', 'dislikeuser', 'gallery', 'matchuser')
        );
    }

    public function userbanned(Request $request)
    {
        return view('user.banned');
    }

    public function userbannedAjaxcall(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length');

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $records = User::select('users.*')
            ->where('status', 0)
            ->skip($start)
            ->take($rowperpage)
            ->orderBy('id', 'desc');

        if ($searchValue != null) {
            $records->where(
                function ($query) use ($searchValue) {
                    $query->where('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('mobile', 'like', '%' . $searchValue . '%');
                }
            );
        }

        $totalRecordswithFilter = $records->count();
        $totalRecords = $totalRecordswithFilter;

        $list = $records->get();

        $data_arr = [];

        foreach ($list as $sno => $record) {
            $id = $record->id;

            $action = '<a class="dropdown-items unbanned" href="javascript:void(0);"
            data-id="' . $id . '" ><i class="bi bi-person-check-fill"></i></a>';
            $action .= '<a class="dropdown-items delete" href="javascript:void(0);"
            data-id="' . $id . '"><i class="bi bi-trash-fill"></i></a>';

            $data_arr[] = [
                'id' => ++$start,
                'user_id' => $record->id,
                'name' => $record->name,
                'email' => $record->email,
                'mobile' => $record->mobile,
                'date' => date('d-m-Y h:i a', strtotime($record->created_at)),
                'Action' => $action,
            ];
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordswithFilter,
            'aaData' => $data_arr,
        ];

        echo json_encode($response);
        exit;
    }

    public function suspenduser(Request $request)
    {

        $id = $request->id;

        if ($request->type == 0) {
            $user = User::where('id', $id)->update(['status' => 0]);
        }

        if ($request->type == 1) {
            $user = User::where('id', $id)->update(['status' => 1]);
        }

        if ($user) {
            return response()->json(
                ['status' => 'success', 'message' => 'Success suspend account.']
            );
        }

        return response()->json(['status' => 'success']);
    }

    public function reportedUser()
    {
        return view('user.report');
    }

    public function reportAjaxcall(Request $request)
    {
        $draw = $request->get('draw');
        $start = $request->get('start');
        $rowperpage = $request->get('length');

        $columnIndex_arr = $request->get('order');
        $columnName_arr = $request->get('columns');
        $order_arr = $request->get('order');
        $search_arr = $request->get('search');

        $columnIndex = $columnIndex_arr[0]['column'];
        $columnName = $columnName_arr[$columnIndex]['data'];
        $columnSortOrder = $order_arr[0]['dir'];
        $searchValue = $search_arr['value'];

        $records = DB::table('report_user')
            ->join('users', 'report_user.pre_user_id', 'users.id')
            ->select('users.*')
            ->where('status', 2)
            ->skip($start)
            ->take($rowperpage)
            ->orderBy('id', 'desc');

        $totalRecordswithFilter = $records->count();
        $totalRecords = $totalRecordswithFilter;

        if ($searchValue != null) {
            $records->where(
                function ($query) use ($searchValue) {
                    $query->where('name', 'like', '%' . $searchValue . '%')
                        ->orWhere('mobile', 'like', '%' . $searchValue . '%');
                }
            );
        }

        $list = $records->get();

        $data_arr = [];

        foreach ($list as $sno => $record) {
            $id = $record->id;

            $data_arr[] = [
                'id' => ++$start,
                'user_id' => $record->id,
                'name' => $record->name,
                'gender' => $record->gender_id ?? '',
                'subgender' => $record->sub_gender_id ?? '',
                'height' => $record->height_id ?? '',
                'service' => $record->service_id ?? '',
                'about' => $record->about_me ?? '',
                'relation' => $record->relation_id ?? '',
                'email' => $record->email,
                'mobile' => $record->mobile,
                'date' => date('d-m-Y h:i a', strtotime($record->created_at)),
            ];
        }

        $response = [
            'draw' => intval($draw),
            'iTotalRecords' => $totalRecords,
            'iTotalDisplayRecords' => $totalRecordswithFilter,
            'aaData' => $data_arr,
        ];

        echo json_encode($response);
    }

    public function profile()
    {
        return view('user.profile');
    }

    public function profileSave(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'new_password' => 'nullable|min:6',
                'confirm_password' => 'nullable|same:new_password',
            ]
        );

        $data = [];
        $data['name'] = $request->name;

        if (! empty($request->new_password)) {
            $data['password'] = bcrypt($request->new_password);
        }

        User::where('id', Auth::guard('user')->user()->id)
            ->update($data);

        return redirect()->back()->with(
            'success',
            'Profile updated successfully!'
        );
    }

}
