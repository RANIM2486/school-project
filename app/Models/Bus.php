<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bus extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_name',
        'area',
        'phone',
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class, 'bus_student');
    }
}
