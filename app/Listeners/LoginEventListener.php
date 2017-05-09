<?php

namespace App\Listeners;

use App\Events\UserLoggedIn;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Carbon\Carbon;
class LoginEventListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        $user = $event->user;
        $user->is_online = true;
        $user->last_logged_in = Carbon::now();
        $user->save();
        // dd($user);
        event(new UserLoggedIn($user));
    }
}
