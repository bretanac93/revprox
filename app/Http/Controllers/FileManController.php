<?php

namespace App\Http\Controllers;

use App\Facades\NginxFacade;
use App\ReverseProxy;
use Flash;

class FileManController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.files.index')
            ->with('proxy_list', ReverseProxy::all());
    }

    public function edit($id)
    {
        return view('admin.files.edit', [
            'content' => NginxFacade::getFile(ReverseProxy::find($id)->proxy_dns),
            'id'      => $id,
        ]);
    }

    public function update($id)
    {
        $content  = request('file_content');
        $filename = ReverseProxy::find($id)->proxy_dns;
        $data     = NginxFacade::processFileData($filename, $content);

        $proxy = ReverseProxy::whereId($id);
        $proxy->update($data);

        Flash::success('Fichero modificado satisfactoriamente.');
        return redirect(route('files.index'));
    }
}
