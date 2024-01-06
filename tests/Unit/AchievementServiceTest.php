<?php

namespace Tests\Unit;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\Comment;
use App\Models\Lesson;
use App\Models\User;
use App\Models\UserAchievement;
use App\Services\AchievementService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class AchievementServiceTest extends TestCase
{
    use RefreshDatabase;

    public function test_on_comment_added(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        $service = new AchievementService;
        $service->onCommentAdded($comment);

        Event::assertDispatched(AchievementUnlocked::class, function ($event) use ($user) {
            return $event->user->id === $user->id && $event->achievement === 'First Comment Written';
        });
    }

    public function test_on_lesson_watched(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $lesson = Lesson::factory()->create();
        $user->watched()->attach($lesson->id, ['watched' => TRUE]);

        $service = new AchievementService;
        $service->onLessonWatched($user, $lesson);

        Event::assertDispatched(AchievementUnlocked::class, function ($event) use ($user) {
            return $event->user->id === $user->id && $event->achievement === 'First Lesson Watched';
        });
    }

    public function test_get_next_achievements(): void
    {
        $user = User::factory()->create();
        $achievement = UserAchievement::create(['user_id' => $user->id, 'name' => 'First Comment Written']);

        $service = new AchievementService;
        $nextAchievements = $service->getNextAchievements([$achievement->name]);

        $this->assertContains('3 Comments Written', $nextAchievements);
    }

    public function test_on_achievement_added(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $achievement = 'First Comment Written';

        $service = new AchievementService;
        $service->onAchievementAdded($user, $achievement);

        $this->assertDatabaseHas('user_achievements', [
            'user_id' => $user->id,
            'name' => $achievement,
        ]);

        Event::assertDispatched(BadgeUnlocked::class, function ($event) use ($user) {
            return $event->user->id === $user->id && $event->badge === 'Beginner';
        });
    }
}
