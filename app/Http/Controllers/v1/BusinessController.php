<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Business;
use App\Models\IbrDirectCommission;
use App\Models\Package;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    public function index(): JsonResponse
    {
        $business = Business::paginate(15);
        return response()->json($business);
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
        $business = Business::create($data);
        User::where('id', auth()->id())->update(['business_id' => $business->id]);
        if ($business->wasRecentlyCreated) {
            return response()->json($business, 201);
        }
        else {
            return response()->json(['message' => 'There are some internal error to proceeding your request'], 202);
        }
    }

    public function show($id): JsonResponse
    {
        $business = Business::find($id);
        if (!empty($business)) {
            return response()->json($business, 200);
        } else {
            return response()->json(['message' => 'Not Found!'], 404);
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

    public function destroy($id): JsonResponse
    {
        $business = Business::find($id);
        if (empty($business)) {
            return response()->json(['message' => 'Not Found!'], 404);
        } else {
            $business = $business->delete();
            return response()->json($business);
        }
    }
}
