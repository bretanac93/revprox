<?php

namespace App\Http\Controllers;

use App\ReverseProxy;


class ReverseProxyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index() {
        return view('admin.proxies.index')
            ->with('proxy_list', ReverseProxy::all());
    }

    public function create() {
        return view('admin.proxies.create');
    }

}
