<?php

namespace App\Interfaces;

interface PilketumVoterRepositoryInterface 
{
    public function getAllPilketumVoters();
    public function getPilketumVoterById($pilketumId);
    public function checkPilketumVoterHasRegis($memberId);
    public function checkPilketumVoterHasVote($memberId);
}