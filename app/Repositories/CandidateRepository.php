<?php

namespace App\Repositories;

use App\Interfaces\CandidateRepositoryInterface;
use App\Models\Candidate;
use Illuminate\Support\Facades\DB;

class CandidateRepository implements CandidateRepositoryInterface
{
    public function getAllCandidates()
    {
        return Candidate::all();
    }

    public function getCandidateById($candidateId)
    {
        return Candidate::findOrFail($candidateId);
    }

    public function getCandidateInfo($candidateId)
    {
        $candidateInfo = DB::table('pilketum_candidates as candidate')
            ->join('members', 'members.id', '=', 'candidate.member_id')->join('batches', 'batches.id', '=', 'members.batch_id')->where('candidate.id', '=', $candidateId)->select(
                'candidate.id',
                'candidate.pilketum_id',
                'candidate.number as candidate_number',
                'candidate.name',
                'candidate.member_id',
                'candidate.photo',
                'batches.name as candidate_batch',
            )->first();

        return $candidateInfo;
    }


    public function getPilketumCandidatesInfo($pilketumId)
    {
        $pilketumCandidatesInfo = DB::table('pilketum_candidates as candidate')
            ->join('members', 'members.id', '=', 'candidate.member_id')->join('batches', 'batches.id', '=', 'members.batch_id')->where('candidate.pilketum_id', '=', $pilketumId)->select(
                'candidate.id',
                'candidate.pilketum_id',
                'candidate.number',
                'candidate.name',
                'candidate.member_id',
                'candidate.photo',
                'batches.name as candidate_batch',
            )->get();

        return $pilketumCandidatesInfo;
    }
}
