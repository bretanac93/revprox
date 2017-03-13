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

        $string_col = explode("\r\n", $content);



        $col = collect($string_col);


        $to_forget = [];

        for ($i = 0; $i < count($string_col); $i++) {
            $item = $string_col[$i];
            if (!strpos($item, "listen") && !strpos($item, "server_name") && !strpos($item, "proxy_pass")) {
                array_push($to_forget, $i);
            }
        }
        $col->forget($to_forget);

        $col = $col->map(function ($item) {
            $item = trim($item);

            $col = collect(explode(" ", $item))->toArray();

            for ($i = 0; $i < count($col); $i++) {
                if ($this->contains(';', $col[$i]));
                $col[$i] = trim($col[$i], ';');
            }

            return $col;
        });

        dd($this->transformPattern($col));
    }

}