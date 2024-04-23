<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penalty extends Model
{
    use HasFactory;

    protected $guarded = 'id';

    // 1 penalty hanya 1 user
    public function user(){
        return $this->belongsTo(User::class);
    }

    // 1 penalty hanya 1 return car
    public function carReturn(){
        return $this->belongsTo(CarReturn::class);
    }
}
