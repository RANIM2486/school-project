<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'father_name',
        'mother_name',
        'last_name',
        'gender',
        'birth_date',
        //'national_id',
        'address',
        'entry_date',
       // 'user_id',
        'parent_id',
        'class_id',
        'section_id',
    ];

    // العلاقة مع الحساب الخاص بالطالب
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    // العلاقة مع ولي الأمر
    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    // العلاقة مع الصف
    public function class()
    {
        return $this->belongsTo(classes::class);
    }

    // العلاقة مع الشعبة
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    // العلامات التابعة للطالب
    public function grades()
    {
        return $this->hasMany(Grade::class);
    }

    // السجلات كطالب حالي
    public function current()
    {
        return $this->hasOne(Current_Student::class);
    }
        public function fees()
    {
        return $this->hasMany(Fee::class);
    }
}
