<?php

namespace App\Http\Controllers;


use League\Flysystem\Exception;

class PreferencesController extends Controller
{
    public function scripts_index() {
        return view('admin.preferences.index_scripts')
            ->with(['sc1_content' => 'the content of file 1', 'sc2_content' => 'The content of file 2']);
    }

    public function scripts_update() {
        throw new Exception("not implemented");
    }
}
