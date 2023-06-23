<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

use App\Models\PilketumVoter;
use App\Models\PilketumVote;
use App\Models\Pilketum;
use App\Models\User;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

class FormSubmissionDptMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $memberId = $request->user()->member_id;

        $userInfoLog = User::where('member_id', $memberId)->first();
        $userId = $userInfoLog->id;
        $bagIdUser = $userInfoLog->bag_id;
        $ipAddressUser = $userInfoLog->ip_address;
        $nosisUser = $userInfoLog->member_nosis;


        $pilketum = Pilketum::latest('id')->first();
        $isPilketumPhase = (Carbon::now() >= $pilketum->start_at && Carbon::now() <= $pilketum->end_at) ? true : false; 

        $userHasSubmitDpt = PilketumVoter::where('member_id', $memberId)->first();
        $userHasSubmitVote = PilketumVote::where('member_id', $memberId)->first();
        
        if (($userHasSubmitDpt)) {
            if($userHasSubmitVote && $userHasSubmitDpt->vote_at !== null){
                
                // Log data string warning
                Log::error("user dengan member_id : {$memberId}, user_id : {$userId}, bag_id : {$bagIdUser}, ip_address : {$ipAddressUser}, nosis: {$nosisUser} sudah melakukan voting sebelumnya");

                // Redirect the user, sudah pernah melakukan voting
                return redirect()->route('home')->with('user-has-vote', 'Anda sudah melakukan voting sebelumnya');
            } else {
                if($isPilketumPhase){
                    return $next($request);
                } else {
                     // Redirect the user, vote belum dimulai
                     return redirect()->route('home')->with('vote-has-not-started-yet', 'Maaf voting belum dimulai');
                }
            }
        }

        // Log data string warning
        Log::warning("user dengan member_id : {$memberId}, user_id : {$userId}, bag_id : {$bagIdUser}, ip_address : {$ipAddressUser}, nosis: {$nosisUser} tidak terdaftar di DPT");

        // Redirect the user or show an error message
        return redirect()->route('home')->with('not-eligible', 'Maaf akun anda belum memenuhi syarat untuk melakukan vote');
    }
}
