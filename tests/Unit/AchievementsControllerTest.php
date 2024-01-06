<?php

namespace Tests\Unit;

use App\Http\Controllers\AchievementsController;
use App\Services\AchievementService;
use App\Services\BadgeService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;
use App\Models\User;

class AchievementsControllerTest extends TestCase
{
    use RefreshDatabase;

    private $achievementService;
    private $badgeService;
    private $achievementsController;

    public function setUp(): void
    {
        parent::setUp();
        $this->achievementService = $this->createMock(AchievementService::class);
        $this->badgeService = $this->createMock(BadgeService::class);
        $this->achievementsController = new AchievementsController($this->achievementService, $this->badgeService);
    }

    public function testIndex()
    {
        $user = User::factory()->create();
        $this->achievementService->method('getNextAchievements')->willReturn([]);
        $this->badgeService->method('getNextBadgeProgress')->willReturn(0);

        $response = $this->achievementsController->index($user);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertArrayHasKey('unlocked_achievements', $response->getData(true));
    }
}
