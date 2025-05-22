<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Fee extends Model
{
    protected $fillable=['student_id' ,'amount','type','status','due_date'];
    public function student()
{
    return $this->belongsTo(Student::class);
}

}
