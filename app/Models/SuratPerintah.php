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
        'file',
        'file_content',
        'file_name',
        'file_mime',
        'status',
        'sumber_dana'
    ];

    protected $casts = [
        'tanggal_surat' => 'date'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'surat_perintah_user')
            ->withPivot('is_approved');
    }

    // Relationship with Kegiatan
    public function penerima()
    {
        return $this->belongsToMany(User::class, 'surat_perintah_user', 'surat_perintah_id', 'user_id')->withPivot('is_approved');
    }

    // Mengecek apakah semua anggota telah menyetujui surat
    public function isFullyApproved()
    {
        return $this->penerima()->wherePivot('is_approved', false)->count() === 0;
    }
}
