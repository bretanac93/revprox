<?php

namespace App\Http\Controllers;

use App\ReverseProxy;
use App\Facades\NginxFacade;

use Flash;

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

        $func_res = NginxFacade::processFileData($content);
        $data = $func_res[0];
        $res = $func_res[1];

        if ($res[0] = true) {
            $proxy = ReverseProxy::whereId($id);
            $proxy->update($data);
        }

        else {
            Flash::error($res[1]);
            return redirect()->back();
        }

        Flash::success('Fichero modificado satisfactoriamente.');
        return redirect(route('files.index'));
    }
}