<?php

namespace App\Http\Controllers;

use App\AccessLog;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index() {
        return view('admin.access_logs.index')
            ->with('access_logs', AccessLog::all());
    }
}
