<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Current_Student extends Model
{
    use HasFactory;
    protected $table = 'current_students';

    protected $fillable = [
      'student_id',
        'class_id',
        'section_id',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function Attendances()
    {
        return $this->hasMany(Attendance::class);
    }
    public function class()
    {
        return $this->belongsTo(classes::class);
    }
    public function section()
    {
        return $this->belongsTo(Section::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public static function countActive()
    {
        return self::where('status', 'مستمر')->count();
    }
    public static function countPostponed()
    {
        return self::where('status', 'مؤجل')->count();
    }
    public static function countLeft()
    {
        return self::where('status', 'مغادر')->count();
    }
    public static function countBySection($sectionid)
    {
        return self::where('section_id', $sectionid)->count();
    }
    public static function countByClass($classId)
    {
        return self::where('class_id', $classId)->count();
    }

}
