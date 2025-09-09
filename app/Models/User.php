<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // public function courses()
    // {
    //     return $this->hasMany(Course::class);
    // }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_users')
                    ->withPivot('certificate')
                    ->withTimestamps();
    }

    public function materials()
    {
        return $this->belongsToMany(Material::class, 'material_users')
                    ->withPivot('status', 'completed_at')
                    ->withTimestamps();
    }

    public function completedMaterials()
    {
        return $this->belongsToMany(\App\Models\Material::class, 'material_users')
                    ->withTimestamps(); 
    }

    public function examResults()
    {
        return $this->hasMany(ExamResult::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_user');
    }

}
