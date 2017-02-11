<?php

namespace App\Http\Controllers;

use App\Facades\NginxFacade;
use App\Http\Requests\StoreRevProxyRequest;
use App\ReverseProxy;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;
use Laracasts\Flash\Flash;
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
        return view('admin.proxies.create')
            ->with('rev_prox', new ReverseProxy());
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

            if ($whoami !== "root\n") {
                Flash::error('No posee los permisos suficientes para realizar la operación, intente reiniciando el servidor con permisos de administración.');
                return redirect()->back();
            }
            else {
                try {
//                    $this->generate_nginx_file($data['proxy_dns'], $data['server_ip'], $data['has_ssl']);
                    $res = NginxFacade::genNginxFile($data['proxy_dns'], $data['server_ip'], $data['has_ssl']);

                    if ($res[0] = true) {
                        ReverseProxy::create($data);
                    }
                    else {
                        Flash::error($res[1]);
                        return redirect()->back();
                    }

                    Flash::success('Proxy creado satisfactoriamente.');
                    return redirect(route('proxies.index'));
                } catch (\RuntimeException $e) {
                    Flash::error('Error inesperado, intente de nuevo');
//                    dd($e->getMessage());
                    return redirect()->back();
                }
            }
        }
    }

    public function edit($id) {
        if ($id == null)
            return new Response(view('errors.400'), 400);
        $rev_proxy = ReverseProxy::find($id);
        if ($rev_proxy == null)
            return new Response(view('errors.404'), 404);

        return view('admin.proxies.edit')
            ->with('rev_prox', $rev_proxy);
    }

    public function update($id) {
        if ($id == null)
            return new Response(view('errors.400'), 400);
        $rev_proxy = ReverseProxy::find($id);
        if ($rev_proxy == null)
            return new Response(view('errors.404'), 404);

        $old_dns = $rev_proxy->proxy_dns;

        $data = Input::all();

        $rules = ReverseProxy::$rules;

        $validator = \Validator::make($data, $rules);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator);
        }

        if (isset($data['name']))
            $rev_proxy->name = $data['name'];
        if (isset($data['proxy_dns']))
            $rev_proxy->proxy_dns = $data['proxy_dns'];
        if (isset($data['server_ip']))
            $rev_proxy->server_ip = $data['server_ip'];

        try {
            $rm_res = NginxFacade::removeFile($old_dns);

            if (!$rm_res[0])
            {
                Flash::error($rm_res[1]);
                return redirect()->back();
            }

            $res = NginxFacade::genNginxFile($data['proxy_dns'], $data['server_ip'], $data['has_ssl']);

            if ($res[0] = true) {
                $rev_proxy->save();
                Flash::success('Proxy creado satisfactoriamente.');
                return redirect(route('proxies.index'));
            }
            else {
                Flash::error($res[1]);
                return redirect()->back();
            }
        } catch (\RuntimeException $e) {
            Flash::error('Error inesperado, intente de nuevo');
            return redirect()->back();
        }
    }
}
