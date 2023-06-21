<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilketumVoter extends Model
{

    protected $table = 'pilketum_voters';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pilketum_id', 'member_id', 'vote_at', 'no_whatsapp', 'vote_no_whatsapp', 'email', 'vote_email', 'dpt_photo', 'vote_photo', 'is_regis', 'updated_by'
    ];
}
