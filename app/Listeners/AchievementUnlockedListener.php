<?php

namespace App\Listeners;

use App\Events\AchievementUnlocked;
use App\Services\AchievementService;

class AchievementUnlockedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private AchievementService $achievementService)
    {

    }
    /**
     * Handle the event.
     */
    public function handle(AchievementUnlocked $event): void
    {
        $this->achievementService->onAchievementAdded($event->user, $event->achievement);
    }
}
