<?php
// Service to handle all badge related logic
namespace App\Services;

class BadgeService
{
    //Fetch the next badge
    public function getNextBadge($user)
    {
        $badges = [
            'Beginner',
            'Intermediate',
            'Advanced',
            'Master',
        ];

        $userBadges = $user->badges->pluck('name')->toArray();
        $nextBadge = null;
        foreach ($badges as $badge) {
            if (!in_array($badge, $userBadges)) {
                $nextBadge = $badge;
                break;
            }
        }
        return $nextBadge;
    }

    //Fetch the next badge progress
    public function getNextBadgeProgress($user)
    {
        $achievements = $user->achievements->count();
        $badges = [
            'Beginner' => 0,
            'Intermediate' => 4,
            'Advanced' => 8,
            'Master' => 10,
        ];

        $nextBadge = $this->getNextBadge($user);

        $nextBadgeProgress = $badges[$nextBadge];

        return max($nextBadgeProgress - $achievements, 0);
    }
}
