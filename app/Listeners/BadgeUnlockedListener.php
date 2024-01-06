<?php

namespace App\Listeners;

use App\Events\BadgeUnlocked;
use App\Models\UserBadge;

class BadgeUnlockedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(BadgeUnlocked $event): void
    {
        $user = $event->user;
        UserBadge::create([
            'user_id' => $user->id,
            'name' => $event->badge,
        ]);
    }
}
