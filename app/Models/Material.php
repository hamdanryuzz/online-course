<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class material extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'file',
        'description',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'material_users')
                    ->withPivot('status', 'completed_at')
                    ->withTimestamps();
    }

    public function completedByUsers()
    {
        return $this->belongsToMany(\App\Models\User::class, 'material_users')
                    ->withTimestamps();
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }


}
