<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    /**
     * Get the member who has become a candidate.
     */
    public function candidate()
    {
        return $this->hasMany(Candidate::class);
    }
}
