<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Http\Controllers\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable ,HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
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

    public function section()
    {
        return $this->hasOne(Section::class);
    }

    // علاقة مع المعلم (واحد لواحد)
    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    // علاقة مع الموظف (واحد لواحد)
   /* public function employee()
    {
        return $this->hasOne(Employee::class);
    }*/

    // علاقة مع المهام (واحد لعديد)
   /* public function tasks()
    {
        return $this->hasMany(Task::class);
    }*/

    // علاقة مع الطلاب إذا كان ولي أمر
    public function children()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }

}
