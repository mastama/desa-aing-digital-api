<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SocialAssistance extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
        'thumbnail',
        'name',
        'category',
        'amount',
        'provider',
        'description',
        'is_available',
    ];

    // Relationships SocialAssistanceRecipient
    public function socialAssistanceRecipients() {
        return $this->hasMany(SocialAssistanceRecipient::class);
    }
}
