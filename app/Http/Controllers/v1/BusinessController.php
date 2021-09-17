<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $business = Business::paginate(15);
        return response()->json($business, 200);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required',
            'country_name' => 'required',
            'country_code' => 'required',
            'city_name' => 'required',
            'company_logo_url' => 'required|mimes:jpg,bmp,png,JPG,PNG,jpeg',
            'ibr' => 'required',
        ]);

        if ($request->has('company_logo_url')) {
            $path = $request->file('company_logo_url')->store('', 'public');
            $request->merge(['company_logo' => $path]);
        }
        $business = Business::create($request->all());
        if ($business->wasRecentlyCreated) {
            return response()->json($business, 201);
        } else {
            return response()->json(['message' => 'There are some internal error to proceeding your request'], 202);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $business = Business::find($id);
        if (!empty($business)) {
            return response()->json($business, 200);
        } else {
            return response()->json(['message' => 'Not Found!'], 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $business = Business::find($id);
        $validated = $request->validate([
            'company_name' => 'required',
            'country_name' => 'required',
            'country_code' => 'required',
            'city_name' => 'required',
            'company_logo_url' => 'mimes:jpg,bmp,png,JPG,PNG,jpeg',
            'ibr' => 'required',
        ]);

        if (empty($business)) {
            return response()->json(['message' => 'Not Found!'], 404);
        } else {
            if ($request->has('company_logo_url')) {
                $path = $request->file('company_logo_url')->store('', 'public');
                $request->merge(['company_logo' => $path]);
            }
            $business->update($request->all());
            return response()->json($business, 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
