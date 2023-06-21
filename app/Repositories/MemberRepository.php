<?php

namespace App\Repositories;

use App\Interfaces\MemberRepositoryInterface;
use App\Models\Member;
use Illuminate\Support\Facades\DB;
class MemberRepository implements MemberRepositoryInterface
{
    public function getAllMembers()
    {
        return Member::all();
    }

    public function getMemberById($memberId)
    {
        return Member::findOrFail($memberId);
    }

    public function getMemberBatchNameById($memberId)
    {
        return DB::table('batches')
            ->join('members', 'batches.id', '=', 'members.batch_id')
            ->select('batches.name as batch_name')
            ->where('members.id', $memberId)
            ->first();
    }
}
