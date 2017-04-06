<?php

namespace App\Http\Controllers;

use App\ReverseProxy;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        dd(\Auth::user());
        return view('admin.home')
            ->with('proxy_count', ReverseProxy::all()->count());
    }
}
