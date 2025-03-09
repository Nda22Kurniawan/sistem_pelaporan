<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    protected $fillable = [
        'surat_perintah_id',
        'nama_kegiatan',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_selesai',
        'lokasi',
        'penanggung_jawab',
        // 'jumlah_peserta',
        'hasil_kegiatan',
        'kesimpulan',
        'image'
    ];

    // Relationship dengan SuratPerintah
    public function suratPerintah()
    {
        return $this->belongsTo(SuratPerintah::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'kegiatan_user', 'kegiatan_id', 'user_id');
    }

    // App\Models\Kegiatan.php
    // public function images()
    // {
    //     return $this->hasMany(Image::class);
    // }
}
