<?php

namespace App\Http\Controllers;

use Symfony\Component\Process\Process;

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
    }
}
