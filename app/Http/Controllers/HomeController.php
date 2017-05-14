<?php

namespace App\Http\Controllers;

use App\ReverseProxy;

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
        return view('admin.home')
            ->with([
                'proxy_count' => ReverseProxy::all()->count(),
                'users'       => \App\User::where('is_online', true)->limit(8)->get(),
                'operations'  => \App\Audit::orderBy('created_at', 'DESC')->limit(5)->get(),
            ]);
    }

    public function sites_per_file()
    {
        $n_r     = \App\NginxRoute::all();
        $res_arr = [];

        foreach ($n_r as $item) {
            $res_arr[] = ['label' => $item->filename, 'value' => count($item->reverse_proxies)];
        };

        return $res_arr;
    }

    public function online_users()
    {
        $users = \App\User::where('is_online', true)->limit(8)->get();
        return $users;
    }
}
