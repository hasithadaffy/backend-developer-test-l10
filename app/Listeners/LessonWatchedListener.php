<?php

namespace App\Listeners;

use App\Events\LessonWatched;
use App\Services\AchievementService;

class LessonWatchedListener
{
    /**
     * Create the event listener.
     */
    public function __construct(private AchievementService $achievementService)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(LessonWatched $event): void
    {
        $this->achievementService->onLessonWatched($event->user, $event->lesson);
    }
}
