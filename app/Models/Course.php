<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'user_id',
        'category_id',
        'name',
        'description',
        'cover',
    ];

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_users')
                    ->withPivot('certificate')
                    ->withTimestamps();
    }

    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }


}
