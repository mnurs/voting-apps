<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilketumRsvp extends Model
{
    use HasFactory;

    protected $table = 'pilketum_rsvps';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pilketum_id', 'member_id', 'email', 'no_whatsapp', 'photo', 'rsvp_code', 'is_attend',
    ];

}
