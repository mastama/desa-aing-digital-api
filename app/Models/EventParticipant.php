<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventParticipant extends Model
{
    use SoftDeletes, HasUuid;

    // Data yang disimpan untuk tiap event participant pada tabel event_participants
    protected $fillable = [
        'event_id',
        'head_of_family_id', // foreign key
        'quantity',         // jumlah peserta atau tiket
        'total_price',      // total harga (quantity * event.price)
        'payment_status',   // status pembayaran (pending, completed, failed, dll)
    ];

    protected $casts = [
        'quantity' => 'integer',
        'total_price' => 'decimal:2',
    ];

    /**
     * Relasi: satu event participant dimiliki oleh satu event
     * FK: event_participants.event_id -> events.id
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Relasi: satu event participant dimiliki oleh satu head of family
     * FK: event_participants.head_of_family_id -> head_of_families.id
     */
    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class, 'head_of_family_id');
    }
}
