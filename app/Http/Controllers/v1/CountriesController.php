<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CountriesController extends Controller
{

    public function listOfCountries(Request $request)
    {
        if ($request->has('shortCode'))
        {
            $fullURL = 'https://restcountries.com/v3.1/alpha/' . $request->shortCode;
            $response = Http::get($fullURL);
            $data = $response->json();
            $data['BankName'] = $this->getBankList($request->shortCode);
            return $data;
        }
    }

    public function getBankList($shortCode)
    {
        switch ($shortCode)
        {
            case "PK":
                return ['Al Baraka Bank (Pakistan) Limited','Allied Bank Limited','Askari Bank','Bank Alfalah Limited','Bank Al-Habib Limited','BankIslami Pakistan Limited','Citi Bank','Deutsche Bank A.G','The Bank of Tokyo-Mitsubishi UFJ','Dubai Islamic Bank Pakistan Limited','Faysal Bank Limited','First Women Bank Limited','Habib Bank Limited','Standard Chartered Bank (Pakistan) Limited','Habib Metropolitan Bank Limited','Industrial and Commercial Bank of China','Industrial Development Bank of Pakistan','JS Bank Limited','MCB Bank Limited','MCB Islamic Bank Limited','Meezan Bank Limited','National Bank of Pakistan','Bank of Punjab','Sindh Bank','Bank of Khyber','First Women Bank','Bank of Azad Jammu & Kashmir','Bank Alfalah','Bank Al Habib','Faysal Bank','Habib Metropolitan Bank','JS Bank','Samba Bank Limited','Silkbank Limited','Standard Chartered Pakistan','Soneri Bank','Summit Bank','United Bank Limited','Allied Aitebar Islamic Banking','Soneri Mustaqeem Islamic Bank','Dubai Islamic Bank','Al Baraka Bank','Bank Alfalah Islamic','Askari Bank Ltd','MCB Islamic Banking','UBL Islamic Banking','HBL Islamic Banking','Bank Al Habib Islamic Banking','Bank of Punjab Islamic Banking','Faysal Bank (Islamic)','HabibMetro (Sirat Islamic Banking)','Silk Bank (Emaan Islamic Banking)',];
            break;
            default:
                return ['Other'];
        }
    }

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
}
