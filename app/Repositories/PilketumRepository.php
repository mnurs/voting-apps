<?php

namespace App\Repositories;

use App\Interfaces\PilketumRepositoryInterface;
use App\Models\Pilketum;

class PilketumRepository implements PilketumRepositoryInterface
{
    public function getAllPilketums()
    {
        return Pilketum::all();
    }

    public function getPilketumById($pilketumId)
    {
        return Pilketum::findOrFail($pilketumId);
    }
}
