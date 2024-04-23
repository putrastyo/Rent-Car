<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarReturn extends Model
{
    use HasFactory;

    protected $guarded = 'id';

    // 1 return hanya 1 rent
    public function rent(){
        return $this->belongsTo(Rent::class);
    }

    // 1 return hanya 1 penalty
    public function penalty(){
        return $this->belongsTo(Penalty::class);
    }
}
