<?php

namespace App\Http\Controllers;

use App\Models\ConfigDivision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class dashboardController extends Controller
{
    public function __construct()
    {
        $activeDivisions = ConfigDivision::where('status', 1)->orderBy('division_name', 'asc')->get();
        View::share('activeDivisions', $activeDivisions);
    }

    public function dashboard()
    {
        return view('dashboard');
    }
}
