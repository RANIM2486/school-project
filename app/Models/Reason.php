<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $fillable = ['name','value','type'];

    public function points()
    {
        return $this->hasMany(Point::class);
    }
}
