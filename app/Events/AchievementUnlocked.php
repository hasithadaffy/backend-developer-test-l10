<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AchievementUnlocked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $achievement;
    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $achievement)
    {
        $this->user = $user;
        $this->achievement = $achievement;
    }
}
