<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;

    protected $guarded = 'id';

    // 1 rent hanya untuk 1 user
    public function user(){
        return $this->belongsTo(User::class);
    }
}
