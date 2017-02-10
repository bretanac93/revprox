<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRevProxyRequest;
use App\ReverseProxy;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
use Symfony\Component\Process\Process;

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

        $validator = \Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }
        else {

            $p = new Process('whoami');
            $p->run();
            $whoami = $p->getOutput();

            if ($whoami !== "root\n")
                return redirect()->back();
            else {
                try {
                    $this->generate_nginx_file($data['proxy_dns'], $data['server_ip'], $data['has_ssl']);
                    ReverseProxy::create($data);
                    return redirect(route('proxies.index'));
                } catch (\RuntimeException $e) {
                    dd($e->getMessage());
                }
            }
        }
    }
}
