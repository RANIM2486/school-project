<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectTeacher extends Model
{
     use HasFactory;
    protected $table = 'subjects_teachers';

    protected $fillable = [
        'subject_id',
        'section_id',
        'class_id', // تم تغييره هنا
        'teacher_id'
    ];

    // العلاقة مع المادة الدراسية
    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    // العلاقة مع القسم
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // العلاقة مع الصف الدراسي
    public function classModel() // تم تغيير اسم العلاقة
    {
        return $this->belongsTo(Classes::class);
    }

    // العلاقة مع المعلم
    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
}


