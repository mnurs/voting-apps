<?php

namespace App\Interfaces;

interface PilketumRepositoryInterface 
{
    public function getAllPilketums();
    public function getPilketumById($pilketumId);
}