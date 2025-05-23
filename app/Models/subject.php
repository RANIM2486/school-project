<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class subject extends Model
{

    use HasFactory;

    protected $fillable = [
        'name',
        'min_grade',
        'max_grade',
        'exam1',
        'exam2',
        'exam3',
        'final_exam',

    ];


    public function grades()
    {
        return $this->hasMany(Grade::class);
    }
}

