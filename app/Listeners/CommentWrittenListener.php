<?php

namespace App\Listeners;

use App\Events\CommentWritten;
use App\Services\AchievementService;

class CommentWrittenListener
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
    public function handle(CommentWritten $event): void
    {
        $this->achievementService->onCommentAdded($event->comment);
    }
}
