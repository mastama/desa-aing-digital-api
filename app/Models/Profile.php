<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Profil desa: data ringkas tentang desa/kelurahan.
 */
class Profile extends Model
{
    use SoftDeletes, HasUuid;

    // Kolom yang boleh diisi massal
    protected $fillable = [
        'thumbnail',         // path/URL logo/foto profil (opsional)
        'name',              // nama desa/kelurahan
        'about',             // deskripsi singkat (opsional)
        'headman',           // nama kepala desa/lurah
        'people',            // total penduduk
        'agriculture_area',  // luas lahan pertanian (mis. hektar)
        'total_area',        // total luas wilayah
    ];

    // Casting tipe data agar konsisten saat diakses
    protected $casts = [
        'people'            => 'integer',
        'agriculture_area'  => 'decimal:4',
        'total_area'        => 'decimal:4',
    ];

    /**
     * Relasi: satu Profile punya banyak gambar tambahan.
     * FK: profile_images.profile_id -> profiles.id
     */
    public function profileImages()
    {
        return $this->hasMany(ProfileImage::class);
    }
}
