<?php

namespace App\Interfaces;

interface MemberRepositoryInterface 
{
    public function getAllMembers();
    public function getMemberById($memberId);
    public function getMemberBatchNameById($memberId);
}