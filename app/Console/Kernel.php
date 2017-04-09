<?php

namespace App\Console;

use App\AccessLog;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Kassner\LogParser\FormatException;
use Kassner\LogParser\LogParser;
use App\Utils\ExtraMethods;

class Kernel extends ConsoleKernel
{
    use ExtraMethods;
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->call(function () {
             $lines = file('/var/log/nginx/access.log', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
             $parser = new LogParser();
             $parser->setFormat('%h %l %u %t "%r" %>s %O "%{Referer}i" \"%{User-Agent}i"');
             $parsed = [];

             foreach ($lines as $line) {
                 try {
                     $t = $parser->parse($line);
                     $parsed[] = $t;
                 } catch (FormatException $e) {
                     $parsed[] = null;
                 }
             }

             collect($parsed)->filter()->map(function ($item) {
                 $item->time = new Carbon($item->time);
                 AccessLog::create(
                     [
                         'host' => $item->host,
                         'user' => $item->user,
                         'time' => $item->time,
                         'request' => $item->request,
                         'status' => $item->status,
                         'sent_bytes' => $item->sentBytes,
                         'referrer' => $item->HeaderReferer,
                         'user_agent' => $item->HeaderUserAgent
                     ]
                 );
             });
             $this->exec('rm -rf /var/log/nginx/access.log');
         })->everyMinute();
    }
    //TODO: Add it to init.d
    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
