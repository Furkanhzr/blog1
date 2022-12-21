<?php

namespace App\Http\Controllers\Back;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Controller
{

    public function index() {
        $admin = Auth::user();
        return view('back.dashboard',compact('admin'));
    }
}
