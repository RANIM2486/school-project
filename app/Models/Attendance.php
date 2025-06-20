<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Attendance extends Model
{
    use HasFactory;
    protected $fillable=['current_student_id','guide_id','attendance_date','status'];
    public function current_students()
{
    return $this->belongsTo(current_student::class);
}

public function guide()
{
    return $this->belongsTo(User::class, 'guide_id')->where('role', 'guide');
}

}
