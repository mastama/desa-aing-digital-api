<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes, HasUuid;

    // kolom yang boleh diisi (mass assignment) oleh user atau aplikasi lain
    protected $fillable = [
        'thumbnail',
        'name',
        'description',
        'price',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'is_active',
        'head_of_family_id', // foreign key
    ];

    // casting tipe data supaya saat diambil dari database sudah sesuai tipe data yang diinginkan
    protected $casts = [
        'price' => 'decimal:2',
        'start_date' => 'date',
        'start_time' => 'time',
        'end_date' => 'date',
        'end_time' => 'time',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi: satu event memiliki banyak event participants
     * FK: event_participants.event_id -> events.id
     */
    public function eventParticipants()
    {
        return $this->hasMany(EventParticipant::class);
    }

    /**
     * Relasi: satu event dimiliki oleh satu head of family
     * FK: events.head_of_family_id -> head_of_families.id
     */
    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class, 'head_of_family_id');
    }
}
