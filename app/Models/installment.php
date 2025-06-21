<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class installment extends Model
{
    protected $fillable=['fee_id','amount','status','due_date'];
    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }
}
