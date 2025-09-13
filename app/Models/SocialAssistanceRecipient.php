<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasUuid;

/**
 * Penerima Bantuan Sosial (Social Assistance Recipient)
 * Berelasi dengan program bantuan sosial (SocialAssistance) tertentu dan kepala keluarga (HeadOfFamily) penerima bantuan.
 */
class SocialAssistanceRecipient extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
        'social_assistance_id', // Foreign key to SocialAssistance (program yang diberikan)
        'head_of_family_id',    // Foreign key to HeadOfFamily (kepala keluarga penerima)
        'amount',               // Jumlah atau nominal bantuan yang diterima
        'reason',               // Alasan penerimaan bantuan
        'bank',                 // string bebas (validasi di FormRequest/Controller)
        'account_number',      // Nomor rekening penerima
        'proof_of_transfer',   // bukti transfer (misal: foto struk)
        'status',               // Status penerimaan (misal: pending, approved, rejected)
        'period_month',       // Periode bulan penerimaan bantuan
        'period_year'         // Periode tahun penerimaan bantuan
    ];

    // Casting attributes to appropriate data types
    protected $casts = [
        'amount' => 'decimal:2',
        'period_month' => 'integer',
        'period_year' => 'integer',
    ];

    /**
     * Penerimaan ini untuk program bantuan sosial apa.
     * FK: social_assistance_id
     */
    public function socialAssistance() {
        return $this->belongsTo(SocialAssistance::class);
    }

    /**
     * Penerimaan ini untuk HoF (kepala keluarga) siapa.
     * FK: head_of_family_id
     */
    public function headOfFamily() {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
