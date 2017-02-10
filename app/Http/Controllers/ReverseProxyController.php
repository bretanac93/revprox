<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRevProxyRequest;
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

    public function store(StoreRevProxyRequest $request) {
        $data = $request->all();

        if (!isset($data['has_ssl'])) {
            $data['has_ssl'] = false;
        } else {
            $data['has_ssl'] = true;
        }
//        dd($data);
        $rules = ReverseProxy::$rules;
        $messages = [
            'required' => 'El atributo :atribute es requerido',
            'ip' => 'No es una dirección IP válida'
        ];
        $validator = \Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('proxies.create'))
                ->withErrors($validator);
        }
        else {
            ReverseProxy::create($data);
            return redirect(route('proxies.index'));
        }
    }
}
