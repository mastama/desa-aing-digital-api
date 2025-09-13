<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasUuid;

class SocialAssistanceRecipient extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
        'social_assistance_id',
        'head_of_family_id',
        'amount',
        'reason',
        'bank',
        'account_number',
        'proof_of_transfer',
        'status',
    ];

    // Relationships SocialAssistance
    public function socialAssistance() {
        return $this->belongsTo(SocialAssistance::class);
    }

    // Relationships HeadOfFamily
    public function headOfFamily() {
        return $this->belongsTo(HeadOfFamily::class);
    }
}
