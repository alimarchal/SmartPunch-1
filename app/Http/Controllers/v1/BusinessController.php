<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PackageUpdate;
use App\Models\Business;
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

class trBusinessController extends Controller
{
    public function index(): JsonResponse
    {
        $business = Business::firstWhere('user_id', auth()->id());

        if (!empty($business)) {
            return response()->json($business);
        }
        else {
            return response()->json(['error' => 'Not Found!'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'company_name' => 'required',
            'country_name' => 'required',
            'country_code' => 'required',
            'city_name' => 'required',
            'company_logo_url' => 'mimes:jpg,bmp,png,JPG,PNG,jpeg',
        ]);

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
                'status' => 1,
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

    public function update(Request $request, $id): JsonResponse
    {
        $business = Business::find($id);
        $validated = $request->validate([
            'company_logo_url' => 'mimes:jpg,bmp,png,JPG,PNG,jpeg',
        ]);

        if (empty($business)) {
            return response()->json(['message' => 'Not Found!'], 404);
        } else {
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
        $packageAmount = Package::firstWhere('id', $request->package_id);
        if ($request->package_type == 1)    /* 1 => monthly */{
            $request->merge(['amount' => $packageAmount->monthly]);
        }
        if ($request->package_type == 2)    /* 2 => quarterly */{
            $request->merge(['amount' => $packageAmount->quarterly]);
        }
        if ($request->package_type == 3)    /* 3 => half year */{
            $request->merge(['amount' => $packageAmount->half_year]);
        }
        if ($request->package_type == 4)    /* 4 => Year */{
            $request->merge(['amount' => $packageAmount->yearly]);
        }

        $data = [
            'business_id' => auth()->user()->business_id,
            'package_id' => $request->package_id,
            'package_type' => $request->package_type,
            'card_number' => $request->card_number,
            'cvv' => $request->cvv,
            'card_valid_from' => $request->card_valid_from,
            'card_valid_to' => $request->card_valid_to,
            'amount' => $request->amount,
            'bank_name' => $request->bank_name,
            'status' => 1,
        ];

        $businessPackage = DB::transaction(function () use ($data, $request) {
            $previousTransaction = auth()->user()->business->transactions()->where('status', 1)->first();
            $previousTransaction->update(['status' => 0]);
            $previousTransaction->businessPackage()->where('status', 1)->update(['status' => 0]);
            $transaction = Transaction::create($data);

            if ($request->package_type == 1)    /* 1 => monthly */{
                $end_date = Carbon::now()->addMonthNoOverflow();
            }
            if ($request->package_type == 2)    /* 2 => quarterly */{
                $end_date = Carbon::now()->addMonthsNoOverflow(4);
            }
            if ($request->package_type == 3)    /* 3 => half year */{
                $end_date = Carbon::now()->addMonthsNoOverflow(6);
            }
            if ($request->package_type == 4)    /* 4 => Year */{
                $end_date = Carbon::now()->addYearNoOverflow();
            }

            $businessPackage = $transaction->businessPackage()->create([
                'business_id' => $transaction->business_id,
                'transaction_id' => $transaction->id,
                'package_id' => $transaction->package_id,
                'package_type' => $request->package_type,
                'package_amount' => $transaction->amount,
                'start_date' => Carbon::now(),
                'end_date' => $end_date,
            ]);

            if (auth()->user()->business->ibr)
            {
                $ibr = Ibr::firstWhere('ibr_no', auth()->user()->business->ibr);
                $tenPercentOfAmount = $transaction->amount * 0.1;

                IbrDirectCommission::create([
                    'ibr_no' => $ibr->ibr_no,
                    'business_id' => $transaction->business_id,
                    'amount' => $tenPercentOfAmount,
                ]);

                $businessID = auth()->user()->business;
                $amount = $tenPercentOfAmount;
                $this->getTopIBRParent($ibr, $amount, $businessID);
            }

            return $businessPackage;
        });

        if ($businessPackage->wasRecentlyCreated) {
            /* status 201 => created */
            return response()->json([
                'success' => 'Business package updated successfully!',
                'businessPackage' => $businessPackage
            ], 201);
        }
        else {
            return response()->json(['message' => 'There are some internal error to proceeding your request. Try again later'], 500);
        }
    }

    function getTopIBRParent($ibr, $amount, $businessID)
    {
        if ($ibr->referred_by == null)
        {
            return $ibr;
        }

        $parentIBR = Ibr::firstWhere('ibr_no', $ibr->referred_by);
        $tenPercentOfAmountAfter = $amount * 0.1;
        IbrIndirectCommission::create([
            'ibr_no' => $parentIBR->ibr_no,
            'referencee_ire_no' => $parentIBR->referred_by,
            'business_id' => $businessID,
            'amount' => $tenPercentOfAmountAfter,
        ]);

        return $this->getTopIBRParent($parentIBR, $tenPercentOfAmountAfter, $businessID);
    }

}
