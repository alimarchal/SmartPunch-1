<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Models\PunchTable;
use Illuminate\Http\Request;

class PunchTableController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }


    public function punch_in(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'office_id' => 'required',
            'business_id' => 'required',
            'time' => 'required',
            'in_out_status' => 'required',
        ]);

        $punch_table = PunchTable::create($request->all());
        if ($punch_table->wasRecentlyCreated) {
            return response()->json($punch_table, 201);
        } else {
            return response()->json(['message' => 'There are some internal error to proceeding your request'], 202);
        }
    }

    public function punch_out(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'office_id' => 'required',
            'business_id' => 'required',
            'time' => 'required',
            'in_out_status' => 'required',
        ]);

        $punch_table = PunchTable::create($request->all());
        if ($punch_table->wasRecentlyCreated) {
            return response()->json($punch_table, 201);
        } else {
            return response()->json(['message' => 'There are some internal error to proceeding your request'], 202);
        }
    }
}
