<?php

namespace App\Http\Controllers;

use App\ReverseProxy;
use App\Facades\NginxFacade;

class FileManController extends Controller
{
    public function index() {
        return view('admin.files.index')
            ->with('proxy_list', ReverseProxy::all());
    }

    public function edit($id) {
        return view('admin.files.edit', [
            'content' => NginxFacade::getFile(ReverseProxy::find($id)->proxy_dns),
            'id' => $id
        ]);
    }
}
