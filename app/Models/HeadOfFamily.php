<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadOfFamily extends Model
{
    use SoftDeletes, HasUuid;

    /**
     * Kolom yang boleh diisi (mass assignment) oleh user atau aplikasi lain
     * Profil Kepala Keluarga pada tabel head_of_families
     */
    protected $fillable = [
        'user_id',
        'profile_picture',
        'identity_number',
        'gender',
        'date_of_birth',
        'phone_number',
        'occupation',
        'marital_status',
    ];

    /**
     * Relasi: satu head of family dimiliki oleh satu user
     * FK: head_of_families.user_id -> users.id
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi: satu head of family memiliki banyak family members
     * FK: family_members.head_of_family_id -> head_of_families.id
     */
    public function familyMembers()
    {
        return $this->hasMany(FamilyMember::class);
    }

    /**
     * Relasi: satu head of family memiliki banyak social assistance recipients (penerima bantuan sosial)
     * FK: social_assistance_recipients.head_of_family_id -> head_of_families.id
     */
    public function socialAssistanceRecipients() {
        return $this->hasMany(SocialAssistanceRecipient::class);
    }

    /**
     * Relasi: satu head of family memiliki banyak events
     * FK: events.head_of_family_id -> head_of_families.id
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'head_of_family_id');
    }

    /**
     * Relasi: satu head of family memiliki banyak event participants
     * FK: event_participants.head_of_family_id -> head_of_families.id
     */
    public function eventParticipants() {
        return $this->hasMany(EventParticipant::class, 'head_of_family_id');
    }
}
