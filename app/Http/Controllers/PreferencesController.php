<?php

namespace App\Http\Controllers;

use App\Facades\NginxFacade;
use App\NginxRoute;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\Input;

class PreferencesController extends Controller
{
    public function scripts_index() {
        $p = new Process('cat gen_http_file.sh');
        $p->run();
        $sc1 = $p->getOutput();

        $p = new Process('cat gen_ssl_file.sh');
        $p->run();
        $sc2 = $p->getOutput();
        return view('admin.preferences.index_scripts')
            ->with(['sc1_content' => $sc1, 'sc2_content' => $sc2]);
    }

    public function scripts_update() {
        $dict = ['http' => 'gen_http_file.sh', 'https' => 'gen_ssl_file.sh'];
        $file = $dict[request('_file_id')];
        $content = request('file_content');

        $this->exec("mv $file $file.bak");
        $this->exec("touch $file");
//        $this->exec("echo $content > $file");
        $res = file_put_contents($file, $content);

        if ($res != false) {
            return redirect()->to(route('preferences.scripts.index'));
        }
        return redirect()->back();
    }

    public function routes_index() {
        // Get all files and list them
        // Make a copy of them in the db
        return view('admin.preferences.index_routes')
            ->with(['nginx_routes' => NginxRoute::all()]);
    }

    public function routes_create() {
        return view('admin.preferences.create_route')
            ->with('route', new NginxRoute);
    }

    public function routes_store() {
        $data = Input::all();

        $res = NginxFacade::createRouteFile(str_slug($data['name']), $data['ip_allow']);

        if ($res)
            NginxRoute::create($data);
        else
            \Flash::error("Error inesperado generando el fichero de rutas, intente de nuevo");

        return redirect()->to(route('preferences.routes.index'));
    }

    public function routes_edit($id) {
        $nginx_route = NginxRoute::whereId($id)->get()->first();
        if ($nginx_route == null) {
            return view('errors.404', [], 404);
        }

        return view('admin.preferences.update_route')
            ->with(['route' => $nginx_route]);
    }

    public function routes_update($id) {
        $data = Input::all();
        $nginx_route = NginxRoute::whereId($id)->get()->first();

        if ($nginx_route == null) {
            return view('errors.404', [], 404);
        }
        $res = NginxFacade::createRouteFile(str_slug($data['name']), $data['ip_allow']);

        if ($res)
            $nginx_route->update($data);
        else
            \Flash::error("Error inesperado generando el fichero de rutas, intente de nuevo");
        return redirect()->to(route('preferences.routes.index'));
    }

    public function routes_remove($id) {
        $nginx_route = NginxRoute::find($id);
//        dd($nginx_route);
        if ($nginx_route == null) {
            return view('errors.404', [], 404);
        }
        NginxFacade::removeRouteFile(str_slug($nginx_route->name));

        $nginx_route->delete();

        return redirect()->to(route('preferences.routes.index'));
    }
}