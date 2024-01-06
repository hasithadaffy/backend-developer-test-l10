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
        $badge = new UserBadge(['name' => 'Beginner']);
        $user->badges()->save($badge);
        $nextBadge = $badgeService->getNextBadge($user);
        $this->assertEquals('Intermediate', $nextBadge);

        // Add 'Intermediate' badge to user
        $badge = new UserBadge(['name' => 'Intermediate']);
        $user->badges()->save($badge);
        $nextBadge = $badgeService->getNextBadge($user);
        $this->assertEquals('Advanced', $nextBadge);

        // Add 'Advanced' badge to user
        $badge = new UserBadge(['name' => 'Advanced']);
        $user->badges()->save($badge);
        $nextBadge = $badgeService->getNextBadge($user);
        $this->assertEquals('Master', $nextBadge);

        // Add 'Master' badge to user
        $badge = new UserBadge(['name' => 'Master']);
        $user->badges()->save($badge);
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
        $user->achievements()->create(['name' => 'Achievement 1']);
        $user->badges()->create(['name' => 'Beginner']);
        $nextBadgeProgress = $badgeService->getNextBadgeProgress($user);
        $this->assertEquals(3, $nextBadgeProgress);
    }
}
