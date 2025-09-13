<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DevelopmentApplicant extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
        'development_id',   // proyek yang diajukan
        'user_id',         // user yang mengajukan
        'status',       // status pengajuan (pending, approved, rejected)
    ];


    protected $casts = [
        'status' => 'string',
    ];

    /**
     * Pengajuan ini untuk proyek yang mana
     */
    public function development()
    {
        return $this->belongsTo(Development::class);
    }

    /**
     * Pengajuan ini dibuat oleh user siapa
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
