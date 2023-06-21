<?php

namespace App\Repositories;

use App\Interfaces\PilketumVoterRepositoryInterface;
use App\Models\PilketumVoter;

class PilketumVoterRepository implements PilketumVoterRepositoryInterface
{
    public function getAllPilketumVoters()
    {
        return PilketumVoter::all();
    }

    public function getPilketumVoterById($pilketumId)
    {
        return PilketumVoter::where('pilketum_id', $pilketumId)->get();
    }

    public function checkPilketumVoterHasRegis($memberId)
    {
        $hasRegis = PilketumVoter::where('member_id', $memberId)->where('is_regis', '=', 'Y')->first();
        if (!empty($hasRegis)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkPilketumVoterHasVote($memberId)
    {
        $hasVote = PilketumVoter::where('member_id', $memberId)->where('vote_at', '!=', null)->first();
        if (!empty($hasVote)) {
            return true;
        } else {
            return false;
        }
    }

    public function checkPilketumVoterHasRegisRsvp($memberId)
    {
        $hasRegisRsvp = PilketumVoter::where('member_id', $memberId)->where('is_attend', '=', 'N')->first();
        if (!empty($hasRegisRsvp)) {
            return true;
        } else {
            return false;
        }
    }
}
