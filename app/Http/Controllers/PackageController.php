<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Contracts\View\View;

class PackageController extends Controller
{
    public function index(): View
    {
        $packages = Package::get()->take(8);
        return view('package.index', compact('packages'));
    }
}
