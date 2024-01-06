<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AchievementService;
use App\Services\BadgeService;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function __construct(private AchievementService $achievementService, private BadgeService $badgeService)
    {

    }
    public function index(User $user)
    {
        // Fetch all User achievements
        $achievements = $user->achievements()->get()->pluck('name')->toArray();

        // Fetch next available achievements
        $nextAvailableAchievements = $this->achievementService->getNextAchievements($achievements);

        // Fetch current badge
        $currentBadge = $user->badges()->orderBy('created_at', 'desc')->first();

        // Fetch remaining to unlock next badge count
        $remainingToUnlockNextBadge = $this->badgeService->getNextBadgeProgress($user);


        return response()->json([
            'unlocked_achievements' => [$achievements],
            'next_available_achievements' => [$nextAvailableAchievements],
            'current_badge' => $currentBadge ? $currentBadge->name : '',
            'next_badge' => $this->badgeService->getNextBadge($user),
            'remaining_to_unlock_next_badge' => $remainingToUnlockNextBadge
        ]);
    }
}
