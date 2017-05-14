<?php

namespace App\Http\Controllers;

use App\NginxRoute;
use Illuminate\Http\Request;
use Symfony\Component\Process\Process;

class PreferencesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function scripts_index()
    {
        $p = new Process('cat gen_http_file.sh');
        $p->run();
        $sc1 = $p->getOutput();

        $p = new Process('cat gen_ssl_file.sh');
        $p->run();
        $sc2 = $p->getOutput();
        return view('admin.preferences.index_scripts')
            ->with(['sc1_content' => $sc1, 'sc2_content' => $sc2]);
    }

    public function scripts_update()
    {
        $dict    = ['http' => 'gen_http_file.sh', 'https' => 'gen_ssl_file.sh'];
        $file    = $dict[request('_file_id')];
        $content = request('file_content');

        $this->exec("sudo mv $file $file.bak");
        $this->exec("sudo touch $file");
	//file_put_contents($file, $content);
	$this->exec("sudo gen_file.sh '$content' '$file'");

        return redirect()->to(route('preferences.scripts.index'));
    }

    public function routes_index()
    {
        // Get all files and list them
        // Make a copy of them in the db
        return view('admin.preferences.index_routes')
            ->with(['nginx_routes' => NginxRoute::all()]);
    }

    public function routes_store(Request $request)
    {
        $file     = $request->file('visibility_file');
        $filename = $file->getClientOriginalName();

        try {
            if (file_exists("visibility_files/$filename")) {
                $path     = public_path() . '/visibility_files';
                $original = "$path/$filename";

                // Backup to the downloadable file
                $this->exec("mv $original $path/$filename.bak");

                // Copy the uploaded file to the downloadable directory
                $file->move(public_path('/visibility_files'), $filename);

                // Backup the file in the nginx routes dir
                $this->exec("sudo mv /etc/nginx/routes/$filename /etc/nginx/routes/$filename.bak");

                // And copy the new one.
                $this->exec("sudo cp visibility_files/$filename /etc/nginx/routes/$filename");

                $n_route = NginxRoute::where('filename', $filename);
                $n_route->update([
                    'updated_at' => \Carbon\Carbon::now()
                ]);
            } else {
                // The file is new, so let's copy it for the first time.
                $file->move(public_path('/visibility_files'), $filename);
                $this->exec("sudo cp visibility_files/$filename /etc/nginx/routes/$filename");

                NginxRoute::create([
                    'real_path'    => "/etc/nginx/routes/$filename",
                    'downloadable' => "visibility_files/$filename",
                    'filename'     => $filename,
                ]);
            }
            // Once the file is copied then persist to the db
        } catch (FileException $e) {
            Flash::error('No se ha podido subir el fichero, intente de nuevo');
        }
        return redirect()->to(route('preferences.routes.index'));
    }

    // Download
    public function routes_edit($id)
    {
        $nginx_route = NginxRoute::whereId($id)->get()->first();

        if ($nginx_route == null) {
            return view('errors.404', [], 404);
        }

        return response()->download($nginx_route->downloadable);
    }

    public function check_bak($filename)
    {
        $data = trim($this->exec("sudo ls /etc/nginx/routes | grep $filename.bak"));
        return ['data' => $data];
    }
    // Ajax
    public function routes_remove($id)
    {
        $nginx_route = NginxRoute::find($id);
        if ($nginx_route == null) {
            return view('errors.404', [], 404);
        }

        $choice = request('with_backup');

        $path = public_path() . '/visibility_files';

        if ($choice == 1) {
            $this->exec("sudo rm -f /etc/nginx/routes/$nginx_route->filename");
        } else {
            $this->exec("sudo mv /etc/nginx/routes/$nginx_route->filename /etc/nginx/routes/$nginx_route->filename.bak");
        }

        // Need to mv the websites conf files belonging to the visibility file we want to remove.

        $proxies = $nginx_route->reverse_proxies;

        $nginx_route->delete();
        $this->exec("sudo rm -rf $path/$nginx_route->filename");
        $this->exec("sudo rm -rf $path/$nginx_route->filename.bak");

        foreach ($proxies as $item) {
            $item->is_active = false;
            $this->exec("sudo rm /etc/nginx/sites-enabled/$item->proxy_dns");
            $item->save();
        }

        return response(['data' => 'Successfully', 'code' => 200], 200);
    }
}
