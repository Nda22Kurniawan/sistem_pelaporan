<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratPerintah extends Model
{
    use HasFactory;

    protected $table = 'surat_perintahs';

    protected $fillable = [
        'nomor_surat',
        'tanggal_surat',
        'perihal',
        'dasar_surat',
        'file'
    ];

    protected $casts = [
        'tanggal_surat' => 'date'
    ];
    
    public function users()
    {
        return $this->belongsToMany(User::class, 'surat_perintah_user');
    }

    // Relationship with Kegiatan
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class);
    }
}