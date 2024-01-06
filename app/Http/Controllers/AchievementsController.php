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
        $achievements = $user->achievements()->get()->pluck('name')->toArray();
        $nextAvailableAchievements = $this->achievementService->getNextAchievements($achievements);
        $currentBadge = $user->badges()->orderBy('created_at', 'desc')->first();
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
