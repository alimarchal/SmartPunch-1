<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class SuperAdminController extends Controller
{
    public function dashboard(): View
    {
        return view('superAdmin.dashboard');
    }
}
