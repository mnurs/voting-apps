<?php

namespace App\Interfaces;

interface CandidateRepositoryInterface 
{
    public function getAllCandidates();
    public function getCandidateById($candidateId);
    public function getCandidateInfo($pilketumId);
}