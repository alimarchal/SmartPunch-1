<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::all();
        return view('office.index', compact('offices'));
    }

    public function create()
    {
        return view('office.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email'],
            'address' => ['required', 'max:254'],
            'city' => ['required'],
            'phone' => ['required'],
            'coordinates' => ['required'],
        ])->validate();

        $data = [
            'business_id' => auth()->user()->business->id,
            'name' => $request->name,
            'email' => $request->email,
            'address' => $request->address,
            'city' => $request->city,
            'phone' => $request->phone,
        ];

        Office::create($data);

        return redirect()->route('officeIndex')->with('success', 'Office added successfully!');
    }

}
