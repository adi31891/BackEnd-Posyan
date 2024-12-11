<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class warga extends Model
{
    use HasFactory;

    protected $table = 'warga'; 

    protected $fillable = [
        'no_kk',
        'nik',
        'nama',
        'tempat_lahir',
        'Jenis_Kelamin',
        'tgl_lahir',
        'Anak_ke',
        'relasi_keluarga_id',
        'alamat',
        'rt_alamat',
        'no_telp_hp',
        'is_deleted',
        'is_meninggal',
    ];

    protected $casts = [
        'is_deleted' => 'boolean',
        'is_meninggal' => 'boolean',
        'tgl_lahir' => 'date',
    ];

}
