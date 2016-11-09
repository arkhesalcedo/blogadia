<?php

namespace App\Listeners;

use App\Events\NewUserRegister;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class CreateUserProfile
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
     * @param  NewUserRegister  $event
     * @return void
     */
    public function handle(NewUserRegister $event)
    {
        if (!$event->user->hasRole('administrator')) {
            $event->user->createInfo();
        }
    }
}
