<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FamilyMember extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
        'head_of_family_id',
        'user_id',
        'profile_picture',
        'identity_number',
        'gender',
        'date_of_birth',
        'phone_number',
        'occupation',
        'marital_status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function headOfFamily()
    {
        return $this->belongsTo(HeadOfFamily::class, 'head_of_family_id');
    }
}
