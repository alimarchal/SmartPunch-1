<?php

namespace App\Http\Controllers;

use App\Models\Ibr;
use App\Models\Package;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::get()->take(8);
        return view('package.index', compact('packages'));
    }
}
