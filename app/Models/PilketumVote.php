<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilketumVote extends Model
{

    protected $table = 'pilketum_votes';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pilketum_id', 'reference_key', 'vote', 'vote_at', 'email', 'bag_id', 'pilketum_voters_id', 'member_id', 'ip_address'
    ];
}
