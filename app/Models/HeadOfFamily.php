<?php

namespace App\Models;

use App\Traits\HasUuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HeadOfFamily extends Model
{
    use SoftDeletes, HasUuid;

    protected $fillable = [
        'user_id',
        'profile_picture',
        'idendity_number',
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
}
