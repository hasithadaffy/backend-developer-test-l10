<?php

//Service to handle all achievements related logic
namespace App\Services;

use App\Events\AchievementUnlocked;
use App\Events\BadgeUnlocked;
use App\Models\UserAchievement;

class AchievementService
{
    //Dispatch the event when a comment is added
    public function onCommentAdded($comment): void
    {
        $user = $comment->user;
        $comments = $user->comments->count();

        $commentAchievements = [
            1 => 'First Comment Written',
            3 => '3 Comments Written',
            5 => '5 Comments Written',
            10 => '10 Comments Written',
            20 => '20 Comments Written',
            // Add more achievements as needed
        ];

        foreach ($commentAchievements as $commentCount => $achievement) {
            if ($comments == $commentCount) {
                AchievementUnlocked::dispatch($user, $achievement);
                break;
            }
        }
    }

    //Dispatch the event when a lesson is watched
    public function onLessonWatched($user, $lesson): void
    {
        $user->watched()->attach($lesson->id, ['watched' => TRUE]);
        $watchedCount = $user->watched()->where('watched', TRUE)->count();

        $lessonAchievements = [
            1 => 'First Lesson Watched',
            5 => '5 Lessons Watched',
            10 => '10 Lessons Watched',
            25 => '25 Lessons Watched',
            50 => '50 Lessons Watched',
            // Add more achievements as needed
        ];

        foreach ($lessonAchievements as $lessonCount => $achievement) {
            if ($watchedCount >= $lessonCount) {
                AchievementUnlocked::dispatch($user, $achievement);
            }
        }
    }

    //Fetch the next achievements
    public function getNextAchievements($userAchievements): array
    {
        $allAchievements = [
            'First Comment Written',
            '3 Comments Written',
            '5 Comments Written',
            '10 Comments Written',
            '20 Comments Written',
            'First Lesson Watched',
            '5 Lessons Watched',
            '10 Lessons Watched',
            '25 Lessons Watched',
            '50 Lessons Watched',
        ];

        $remainingAchievements = array_diff($allAchievements, $userAchievements);

        return array_values($remainingAchievements);
    }

    //Dispatch the event when an achievement is unlocked
    public function onAchievementAdded($user, $achievement): void
    {
        $achievements = UserAchievement::where('user_id', $user->id)->count();
        if ($achievements == 0) {
            BadgeUnlocked::dispatch($user, 'Beginner');
        }
        UserAchievement::create([
            'user_id' => $user->id,
            'name' => $achievement,
        ]);
        $achievements = UserAchievement::where('user_id', $user->id)->count();
        if ($achievements == 4) {
            BadgeUnlocked::dispatch($user, 'Intermediate');
        } elseif ($achievements == 8) {
            BadgeUnlocked::dispatch($user, 'Advanced');
        } elseif ($achievements == 10) {
            BadgeUnlocked::dispatch($user, 'Master');
        }
    }
}

?>
