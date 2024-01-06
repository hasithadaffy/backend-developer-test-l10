<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\UserBadge;
use App\Services\BadgeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BadgeServiceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test getNextBadge method.
     */
    public function test_get_next_badge(): void
    {
        $badgeService = new BadgeService();

        $user = User::factory()->create();

        // Test when user has no badges
        $nextBadge = $badgeService->getNextBadge($user);
        $this->assertEquals('Beginner', $nextBadge);

        // Add 'Beginner' badge to user
        $this->addBadge($user, 'Beginner');

        $nextBadge = $badgeService->getNextBadge($user);
        $this->assertEquals('Intermediate', $nextBadge);

        // Add 'Intermediate' badge to user
        $this->addBadge($user, 'Intermediate');

        $nextBadge = $badgeService->getNextBadge($user);
        $this->assertEquals('Advanced', $nextBadge);

        // Add 'Advanced' badge to user
        $this->addBadge($user, 'Advanced');

        $nextBadge = $badgeService->getNextBadge($user);
        $this->assertEquals('Master', $nextBadge);

        // Add 'Master' badge to user
        $this->addBadge($user, 'Master');

        $nextBadge = $badgeService->getNextBadge($user);
        $this->assertNull($nextBadge);
    }

    /**
     * Test getNextBadgeProgress method.
     */
    public function test_get_next_badge_progress(): void
    {
        $badgeService = new BadgeService();

        $user = User::factory()->create();

        // Test when user has no achievements
        $nextBadgeProgress = $badgeService->getNextBadgeProgress($user);
        $this->assertEquals(0, $nextBadgeProgress);

        // Add 1 achievement to user
        $this->addAchievement($user, 'Achievement 1');

        // Add 'Beginner' badge to user
        $this->addBadge($user, 'Beginner');

        $nextBadgeProgress = $badgeService->getNextBadgeProgress($user);
        $this->assertEquals(4, $nextBadgeProgress);
    }

    /**
     * Helper method to add a badge to the user.
     */
    private function addBadge(User $user, string $badgeName): void
    {
        $badge = new UserBadge();
        $badge->name = $badgeName;
        $badge->user_id = $user->id;
        $badge->save();
    }

    /**
     * Helper method to add an achievement to the user.
     */
    private function addAchievement(User $user, string $achievementName): void
    {
        $user->achievements()->create(['name' => $achievementName]);
    }
}
