<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class MahasiswaBaru extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'mahasiswa_baru';

    protected $fillable = [
        'nama_lengkap',
        'nim',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'nomor_whatsapp',
        'email',
        'bukti_sosmed',
        'bukti_registrasi',
        'kelompok_id',
        'password',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * --- TAMBAHAN DI SINI ---
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'bukti_sosmed' => 'array', // Otomatis konversi array ke JSON dan sebaliknya
    ];
}