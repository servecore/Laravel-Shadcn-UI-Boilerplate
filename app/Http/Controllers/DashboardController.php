<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the dashboard.
     */
    public function index(Request $request): View
    {
        return view('pages.dashboard.index', [
            'totalUsers' => User::count(),
        ]);
    }
}
