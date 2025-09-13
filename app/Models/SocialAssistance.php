<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Model untuk entitas bantuan sosial.
 * 
 * Program bantuan sosial (definisi program).
 * Contoh: "Bantuan Sembako", "Bantuan Tunai", dst.
 * 
 * Relasi:
 * - socialAssistanceRecipients(): relasi one-to-many ke model SocialAssistanceRecipient
 */
class SocialAssistance extends Model
{
    use SoftDeletes, HasUuid;

    // kolom yang boleh di mass assign 
    protected $fillable = [
        'thumbnail',    // URL/path gambar thumbnail
        'name',         // Nama program bantuan sosial
        'category',    // Kategori bantuan sosial (misal: sembako, pendidikan, kesehatan, dll)
        'amount',      // Jumlah bantuan sosial (nominal standar)
        'provider',    // Penyedia atau penyelenggara bantuan sosial (mis: pemerintah, LSM, , desa, dinas sosial, dll)
        'description', // Deskripsi bantuan sosial  
        'is_available',
    ];

    // Casting tipe data agar saat diambil dari database sudah sesuai tipe data yang diinginkan
    protected $casts = [
        'amount' => 'decimal:2',
        'is_available' => 'boolean',
    ];

    /**
     * Relasi: satu program punya banyak penerima (riwayat penyaluran per Head Of Family)
     * FK: social_assistance_recipients.social_assistance_id -> PK: social_assistances.id
     */
    public function socialAssistanceRecipients() {
        return $this->hasMany(SocialAssistanceRecipient::class);
    }
}
