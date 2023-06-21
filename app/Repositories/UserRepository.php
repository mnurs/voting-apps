<?php

namespace App\Repositories;

use App\Interfaces\UserRepositoryInterface;
use App\Models\User;

class UserRepository implements UserRepositoryInterface 
{
    public function getAllUsers() 
    {
        return User::all();
    }

    public function getUserByMemberId($memberId) 
    {
        return User::where('member_id', $memberId)->where('status', 'active')->first();
    }

}