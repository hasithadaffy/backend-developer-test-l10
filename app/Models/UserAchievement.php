<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAchievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'user_id',
    ];

    protected $visible = [
        'id',
        'name',
        'user_id',
        'created_at',
        'updated_at',
    ];

    /**
     * Get the user that has the achievement.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
