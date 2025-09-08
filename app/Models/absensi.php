<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absensi extends DataMahasiswa
{
    use HasFactory;



    public function kelompokRelasi()
{
    return $this->belongsTo(Kelompok::class, 'kelompok');
}

// app/Models/Mahasiswa.php
public function kelompok()
{
    return $this->belongsTo(Kelompok::class, 'kelompok_id', 'id');
}

public function mahasiswa()
{
    return $this->belongsTo(dataMahasiswa::class, 'mahasiswa_id', 'id');
}

public function dataMahasiswa()
    {
        return $this->belongsTo(DataMahasiswa::class, 'data_mahasiswa_id');
    }
   

}




