<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Transacation;
use App\Services\GooglePlayService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class SubscriptionController extends Controller
{
    public function subscriptionList()
    {
        $subscriptions = Subscription::select('id', 'product_id', 'name', 'price', 'duration', 'product_type', 'description')
            ->orderBy('price', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $subscriptions,
            'message' => 'Premium plans retrieved successfully'
        ], 200);
    }

    public function userSubscription(Request $request)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required|exists:users,id',
                'subscription_id' => 'required|exists:subscriptions,id',
                'payment_method' => 'required',
                'transaction_id' => 'required',
                'currency' => 'required',
                'status' => 'required',
                'description' => 'nullable|string|max:255',
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

        $subscription = Subscription::find($request->subscription_id);
        $startDate = Carbon::now();
        $duration = strtolower(trim($subscription->duration));

        [$number, $unit] = explode(' ', $duration);

        $endDate = null;

        if ($unit === 'month' || $unit === 'months') {
            $endDate = $startDate->copy()->addMonths((int) $number);
        } elseif ($unit === 'year' || $unit === 'years') {
            $endDate = $startDate->copy()->addYears((int) $number);
        } elseif ($unit === 'day' || $unit === 'days') {
            $endDate = $startDate->copy()->addDays((int) $number);
        } else {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'Invalid duration unit in subscription record: ' . $unit,
                ]
            );
        }
        $transaction = new Transacation();
        $transaction->user_id = $request->user_id;
        $transaction->subscription_id = $request->subscription_id;
        $transaction->amount = $subscription->price;
        $transaction->payment_method = $request->payment_method;
        $transaction->status = $request->status;
        $transaction->transaction_id = $request->transaction_id;
        $transaction->currency = $request->currency;
        $transaction->description = $request->description;
        $transaction->updated_at = Carbon::now();
        $transaction->duration = $subscription->duration;
        $transaction->start_date = $startDate->toDateString();
        $transaction->end_date = $endDate->toDateString();
        $transaction->save();

        return response()->json(
            [
                'status' => true,
                'plan_duration' => $number . ' ' . $unit,
                'start_date' => $startDate->toDateString(),
                'end_date' => $endDate->toDateString(),
            ]
        );
    }

    public function googleSubscribe(Request $request, GooglePlayService $googlePlayService)
    {
        $params = $request->all();

        $validator = Validator::make(
            $params,
            [
                'user_id' => 'required|exists:users,id',
                'product_id' => 'required',
                'purchase_token' => 'required',
                'payment_method' => 'required',
                'transaction_id' => 'required',
                'currency' => 'required',
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
        $packageName = 'com.package';
        $googleSubscription = $googlePlayService->verifySubscription(
            $packageName,
            $request->product_id,
            $request->purchase_token
        );

        if (! $googleSubscription) {
            return response()->json(['status' => false, 'message' => 'Invalid or expired purchase token'], 400);
        }

        $subscription = Subscription::where('product_id', $request->product_id)->first();

        if (! $subscription) {
            return response()->json(['status' => false, 'message' => 'Subscription plan not found'], 404);
        }

        $expiryMillis = $googleSubscription->getExpiryTimeMillis();
        $expiryDate = Carbon::createFromTimestampMs($expiryMillis);

        $startDate = Carbon::now();

        $transaction = new Transacation();
        $transaction->user_id = $request->user_id;
        $transaction->subscription_id = $subscription->id;
        $transaction->amount = $subscription->price;
        $transaction->payment_method = $request->payment_method;
        $transaction->status = 'success';
        $transaction->transaction_id = $request->transaction_id;
        $transaction->currency = $request->currency;
        $transaction->duration = $subscription->duration;
        $transaction->start_date = $startDate->toDateString();
        $transaction->end_date = $expiryDate->toDateString();
        $transaction->description = $request->description ?? null;
        $transaction->is_current = 1;
        $transaction->save();

        return response()->json(
            [
                'status' => true,
                'message' => 'Subscription saved successfully',
                'data' => [
                    'plan_name' => $subscription->name,
                    'start_date' => $startDate->toDateString(),
                    'end_date' => $expiryDate->toDateString(),
                ],
            ]
        );
    }

    public function userSubscriptionGet(Request $request)
    {
        $userId = $request->user_id;

        if (! $userId) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'User ID is required.',
                ]
            );
        }

        $subscriptions = Transacation::where('user_id', $userId)
            ->whereDate('end_date', '>=', now())
            ->orderBy('end_date', 'asc')
            ->get();

        if ($subscriptions->isEmpty()) {
            return response()->json(
                [
                    'status' => 'error',
                    'message' => 'No active subscriptions found for this user.',
                ]
            );
        }

        $latestEndDate = $subscriptions->max('end_date');

        $subscriptions = $subscriptions->map(
            function ($subscription) use ($latestEndDate) {
                $subscription->is_current = ($subscription->end_date == $latestEndDate) ? true : false;

                return $subscription;
            }
        );

        return response()->json(
            [
                'status' => 'success',
                'data' => $subscriptions,
            ]
        );
    }
}
