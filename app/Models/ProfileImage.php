<?php

namespace App\Models;
use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Gambar tambahan untuk halaman profil desa.
 */
class ProfileImage extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
        'profile_id', // FK ke profiles.id
        'image_path', // path/URL gambar
    ];

    /**
     * Relasi: gambar ini milik Profile tertentu.
     */
    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
