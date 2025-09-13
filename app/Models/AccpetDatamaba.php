<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccpetDatamaba extends Model
{
    protected $table = "mahasiswa_baru";
    use HasFactory;
  
     protected $fillable = [
        'status'

    ];
}
