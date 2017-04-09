<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SyncNginxLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync the nginx access logs with the database';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
}
