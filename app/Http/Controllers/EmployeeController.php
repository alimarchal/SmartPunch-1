<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\Office;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = User::where('business_id', auth()->user()->business_id)->where('id', '!=', auth()->id())->get();
        return view('employee.index', compact('employees'));
    }

    public function create()
    {
        $businesses = Business::where('user_id', auth()->id())->get();
        $offices = Office::where('business_id', auth()->user()->business_id)->get();
        return view('employee.create', compact('businesses', 'offices'));
    }
}
