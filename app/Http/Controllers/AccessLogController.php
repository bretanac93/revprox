<?php

namespace App\Http\Controllers;

use App\AccessLog;
use Illuminate\Http\Request;

class AccessLogController extends Controller
{
    public function index() {
        return view('admin.access_logs.index')
            ->with('access_logs', AccessLog::all());
    }
}
