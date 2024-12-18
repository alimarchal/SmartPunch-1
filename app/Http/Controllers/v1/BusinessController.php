<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageUpdate;
use App\Http\Resources\BusinessResource;
use App\Models\Business;
use App\Models\BusinessPackages;
use App\Models\Ibr;
use App\Models\IbrDirectCommission;
use App\Models\IbrIndirectCommission;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BusinessController extends Controller
{
    public function index(): JsonResponse
    {
        if (auth()->user()->hasDirectPermission('view business'))
        {
            $business = Business::with('ibr:ibr_no,email')->firstWhere('id', auth()->user()->business_id);

            if (!empty($business)) {
                return response()->json($business);
//            return response()->json(new BusinessResource($business));
            }
            else {
                return response()->json(['error' => 'Not Found!'], 404);
            }
        }
        return response()->json(['error' => 'Access forbidden!!!'], 403);
    }

    public function store(Request $request): JsonResponse
    {
        if (auth()->user()->hasDirectPermission('update business'))
        {
            $request->validate([
                'company_name' => 'required',
                'country_name' => 'required',
                'country_code' => 'required',
                'city_name' => 'required',
                'company_logo_url' => 'mimes:jpg,bmp,png,JPG,PNG,jpeg',
            ]);

            if (isset($request->ibr) && !is_null($request->ibr)){
                $ibr = Ibr::firstWhere('ibr_no', $request->ibr);
                if (!isset($ibr)){
                    return response()->json(['error' => 'Ibr not found'],404);
                }
            }

            if ($request->has('company_logo_url')) {
                $path = $request->file('company_logo_url')->store('', 'public');
                $request->merge(['company_logo' => $path]);
            }

            $data = [
                'user_id' => auth()->id(),
                'company_name' => $request->company_name,
                'country_name' => $request->country_name,
                'country_code' => $request->country_code,
                'city_name' => $request->city_name,
                'company_logo' => $request->company_logo,
                'ibr' => $request->ibr,
            ];
            $business = \DB::transaction(function () use ($data){
                $business = Business::create($data);
                User::where('id', auth()->id())->update(['business_id' => $business->id]);
                $transaction =  Transaction::create([
                    'business_id' => $business->id,
                    'package_id' => 9,
                    'amount' => 0,
                ]);

                $transaction->businessPackage()->create([
                    'business_id' => $transaction->business_id,
                    'transaction_id' => $transaction->id,
                    'package_id' => $transaction->package_id,
                    'package_amount' => $transaction->amount,
                    'start_date' => Carbon::now(),
                    'end_date' => Carbon::now()->addMonthNoOverflow(3),
                ]);

                return $business;
            });
            if ($business->wasRecentlyCreated) {
                return response()->json($business, 201);
            }
            else {
                return response()->json(['message' => 'There are some internal error to proceeding your request'], 500);
            }
        }
        return response()->json(['error' => 'Access forbidden!!!'], 403);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $business = Business::find($id);
        $validated = $request->validate([
            'company_logo_url' => 'mimes:jpg,bmp,png,JPG,PNG,jpeg',
        ]);

        if (empty($business)) {
            return response()->json(['message' => 'Not Found!'], 404);
        }
        else {
            if ($request->has('company_logo_url')) {
                $path = $request->file('company_logo_url')->store('', 'public');
                $request->merge(['company_logo' => $path]);
            }
            $business->update($request->all());
            return response()->json($business);
        }
    }

    public function packageUpdate(PackageUpdate $request): JsonResponse
    {
        $previousBusinessPackage = BusinessPackages::with('package')->firstWhere(['business_id' => auth()->user()->business_id, 'status' => 1]);
        $package = Package::firstWhere('id', $request->package_id);

        /* If a users' employees count is greater than selected package users he will be redirected back */
        if ($previousBusinessPackage->package->users > $package->users){
            $employees = User::where('business_id', auth()->user()->business_id)->get()->except(['id' => auth()->id()]);
            if ($employees->count() > $package->users){
                return response()->json(['error' => 'Your users number exceed to selected package users number.']);
            }
        }

        if ($request->package_type == 1)    /* 1 => monthly */{
            $request->merge(['amount' => $package->monthly]);
        }
        if ($request->package_type == 2)    /* 2 => quarterly */{
            $request->merge(['amount' => $package->quarterly]);
        }
        if ($request->package_type == 3)    /* 3 => half year */{
            $request->merge(['amount' => $package->half_year]);
        }
        if ($request->package_type == 4)    /* 4 => Year */{
            $request->merge(['amount' => $package->yearly]);
        }

        $data = [
            'business_id' => auth()->user()->business_id,
            'package_id' => $request->package_id,
            'package_type' => $request->package_type,
            'card_number' => $request->card_number,
            'card_valid_from' => $request->card_valid_from,
            'card_valid_to' => $request->card_valid_to,
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
        ];

        $transaction = DB::transaction(function () use ($data, $request, $previousBusinessPackage) {
            $transaction = Transaction::create($data);

            if ($request->package_type == 1)    /* 1 => monthly */{
                $end_date = Carbon::parse($previousBusinessPackage->end_date)->addMonthNoOverflow();
            }
            if ($request->package_type == 2)    /* 2 => quarterly */{
                $end_date = Carbon::parse($previousBusinessPackage->end_date)->addMonthsNoOverflow(4);
            }
            if ($request->package_type == 3)    /* 3 => half year */{
                $date = Carbon::parse($previousBusinessPackage->start_date);
                $difference = $date->diffInMonths(Carbon::now());
                if ($difference < 1)   /* Add 2 more months with addition of 6 months if user upgrades to 6 months package within first month of registration to package's end date */{
                    $end_date = Carbon::parse($previousBusinessPackage->end_date)->addMonthsNoOverflow(8);
                }
                if ($difference >= 1 && $difference < 3)   /* Add 1 more month with addition of 6 months if user upgrades to 6 months package after first month but before finishing trial package of registration to package's end date */{
                    $end_date = Carbon::parse($previousBusinessPackage->end_date)->addMonthsNoOverflow(7);
                }
                if ($difference >= 3)   /* Simply add 6 months to package's end date */{
                    $end_date = Carbon::now()->addMonthsNoOverflow(6);
                }
            }
            if ($request->package_type == 4)    /* 4 => Year */{
                $date = Carbon::parse($previousBusinessPackage->start_date);
                $difference = $date->diffInMonths(Carbon::now());
                if ($difference < 1)   /* Add 3 more months with addition of 12 months if user upgrades to a yearly package within first month of registration to package's end date */{
                    $end_date = Carbon::parse($previousBusinessPackage->end_date)->addMonthsNoOverflow(15);
                }
                if ($difference >= 1 && $difference < 3)   /* Add 1 more months with addition of 12 months if user upgrades to a yearly package after first month but before finishing trial package i.e 3 months of registration to package's end date */{
                    $end_date = Carbon::parse($previousBusinessPackage->end_date)->addMonthsNoOverflow(13);
                }
                if ($difference >= 3)   /* Simply add 1 year to package end date */{
                    $end_date = Carbon::parse($previousBusinessPackage->end_date)->addYearNoOverflow();
                }
            }

            $previousBusinessPackage->update([
                'transaction_id' => $transaction->id,
                'package_id' => $transaction->package_id,
                'package_type' => $request->package_type,
                'package_amount' => $transaction->amount,
                'end_date' => $end_date,
            ]);

            /* Calculating IBR commissions if user has used any IBR reference */
            if (auth()->user()->business->ibr)
            {
                $ibr = Ibr::firstWhere('ibr_no', auth()->user()->business->ibr);
                $tenPercentOfAmount = $transaction->amount * 0.1;

                $directCommission = IbrDirectCommission::create([
                    'ibr_no' => $ibr->ibr_no,
                    'transaction_id' => $transaction->id,
                    'amount' => $tenPercentOfAmount,
                ]);

                $businessID = auth()->user()->business;
                $amount = $tenPercentOfAmount;
                $this->getTopIBRParent($ibr, $amount, $businessID, $directCommission);
            }

            return $transaction;
        });

        if ($transaction->wasRecentlyCreated) {
            /* status 201 => created */
            return response()->json(['success' => 'Business package updated successfully!'], 201);
        }
        else {
            return response()->json(['message' => 'There are some internal error to proceeding your request. Try again later'], 500);
        }
    }

    /* Recursion function to calculate indirect commissions */
    function getTopIBRParent($ibr, $amount, $businessID, $directCommission)
    {
        if ($ibr->referred_by == null)
        {
            return $ibr;
        }

        $parentIBR = Ibr::firstWhere('ibr_no', $ibr->referred_by);
        $tenPercentOfAmountAfter = $amount * 0.1;
        IbrIndirectCommission::create([
            'ibr_no' => $parentIBR->ibr_no,
            'referred_by' => $parentIBR->referred_by,
            'ibr_direct_commission_id' => $directCommission->id,
            'business_id' => $businessID,
            'amount' => $tenPercentOfAmountAfter,
        ]);

        return $this->getTopIBRParent($parentIBR, $tenPercentOfAmountAfter, $businessID,$directCommission);
    }

}
