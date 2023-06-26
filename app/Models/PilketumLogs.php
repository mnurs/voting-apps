<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PilketumLogs extends Model
{

    protected $table = 'pilketum_logs';

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'pilketum_id', 'reference_key', 'vote', 'vote_at', 'email', 'bag_id', 'pilketum_voters_id', 'member_id', 'ip_address', 'user_id', 'status','sus_action'
    ];
}
