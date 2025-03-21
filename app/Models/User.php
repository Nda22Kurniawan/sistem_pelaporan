<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nrp',
        'pangkat',
        'jabatan',
        'sub_bidang',
        'role',
        'foto_profile',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function suratPerintah()
    {
        return $this->belongsToMany(SuratPerintah::class, 'surat_perintah_user', 'user_id', 'surat_perintah_id');
    }

    // In the User model
    public function kegiatans()
    {
        return $this->belongsToMany(Kegiatan::class, 'kegiatan_user', 'user_id', 'kegiatan_id');
    }


    public function sedangBertugas()
    {
        return $this->belongsToMany(SuratPerintah::class, 'surat_perintah_user', 'user_id', 'surat_perintah_id')
            ->where('status', 'proses')
            ->exists();
    }
}
