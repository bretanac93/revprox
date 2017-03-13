<?php

namespace App\Http\Controllers;

use App\ReverseProxy;
use App\Facades\NginxFacade;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Process\Process;

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

    public function update($id) {
        $content = request('file_content');

        dd(NginxFacade::processFileData($content));
    }
}