<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * untuk menyimpan data pengembangan proyek atau inisiatif (RT/RW/Desa).
 */
class Development extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
        'thumbnail',            // URL atau path ke gambar thumbnail
        'name',             // Nama pengembangan / proyek
        'description',        // Deskripsi pengembangan / proyek
        'person_in_charge',  // Penanggung jawab pengembangan / proyek
        'start_date',       // Tanggal mulai pengembangan / proyek
        'end_date',         // Tanggal selesai pengembangan / proyek
        'amount',           // Jumlah dana / anggaran yang diajukan
        'status',           // planning|ongoing|completed|cancelled|paused (lihat migration)
        'progress',         // 0..100 (progress pelaksanaan)
    ];

    // Casting untuk konsistensi tipe data saat dibaca/ditulis
    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'amount'     => 'decimal:2',
        'progress'   => 'integer',
    ];

    /**
     * Relasi: satu proyek bisa punya banyak pengaju/pendaftar (proposal).
     * FK: development_applicants.development_id -> developments.id
     */
    public function developmentApplicants()
    {
        return $this->hasMany(DevelopmentApplicant::class);
    }
}
