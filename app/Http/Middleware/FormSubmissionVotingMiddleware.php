<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

use App\Models\PilketumLogs;
use App\Models\PilketumVoter;
use App\Models\PilketumVote;
use App\Models\Pilketum;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;

class FormSubmissionVotingMiddleware
{
    public function handle(Request $request, Closure $next)
    {  
        $memberId = $request->user()->member_id;
        $users = $request->user();

        $candidate_choosen = $request->session()->get('voteinfo.candidate_choosen');
        $userInfoLog = auth()->user();
        $userId = $userInfoLog->id;
        $bagIdUser = $request->bag_id;
        $ipAddressUser = request()->ip();
        $nosisUser = $request->member_nosis;
        $statusUser = $userInfoLog->status;

        $pilketum = Pilketum::latest('id')->first();
        $isPilketumPhase = (Carbon::now() >= $pilketum->start_at && Carbon::now() <= $pilketum->end_at) ? true : false; 

        $userHasSubmitDpt = PilketumVoter::where('member_id', $memberId)->first();
        $userHasSubmitVote = PilketumVote::where('member_id', $memberId)->first();
        

        if($bagIdUser == null){
            $this->createLogs($bagIdUser,$userHasSubmitDpt->id,$users,"bag id kosong",$ipAddressUser,$candidate_choosen);
            Log::warning("user dengan member_id : {$memberId}, user_id : {$userId}, bag_id : {$bagIdUser}, ip_address : {$ipAddressUser}, nosis: {$nosisUser} tidak memiliki bag_id");

            // Redirect the user or show an error message
            return redirect()->route('home')->with('not-eligible', 'Maaf akun anda belum memenuhi syarat untuk melakukan vote');
        }
 
        if($statusUser != 'active'){
            $this->createLogs($bagIdUser,$userHasSubmitDpt->id,$users,$statusUser,$ipAddressUser,$candidate_choosen);
            Log::warning("user dengan member_id : {$memberId}, user_id : {$userId}, bag_id : {$bagIdUser}, ip_address : {$ipAddressUser}, nosis: {$nosisUser} belum terverifikasi 23");

            // Redirect the user or show an error message
            return redirect()->route('home')->with('not-eligible', 'Maaf akun anda belum memenuhi syarat untuk melakukan vote');
        }

        if($ipAddressUser == null){
            $this->createLogs($bagIdUser,$userHasSubmitDpt->id,$users,"ip kosong",$ipAddressUser,$candidate_choosen);
            Log::warning("user dengan member_id : {$memberId}, user_id : {$userId}, bag_id : {$bagIdUser}, ip_address : {$ipAddressUser}, nosis: {$nosisUser} tidak memiliki ip");

            // Redirect the user or show an error message
            return redirect()->route('home')->with('not-eligible', 'Maaf akun anda belum memenuhi syarat untuk melakukan vote');
        }

        if(isset($request->vote_photo)){
            if(filesize($request->vote_photo) < 100000){
                 $this->createLogs($bagIdUser,$userHasSubmitDpt->id,$users,"ukuran foto kecil",$ipAddressUser,$candidate_choosen);
                Log::warning("user dengan member_id : {$memberId}, user_id : {$userId}, bag_id : {$bagIdUser}, ip_address : {$ipAddressUser}, nosis: {$nosisUser} tidak memiliki ip");

                // Redirect the user or show an error message
                return redirect()->route('home')->with('not-eligible', 'File yang anda upload terlalu kecil');
            }   
        }

        if (($userHasSubmitDpt)) {
            if($userHasSubmitVote && $userHasSubmitDpt->vote_at !== null){
                
                // Log data string warning
                $this->createLogs($bagIdUser,$userHasSubmitDpt->id,$users,"sudah voting",$ipAddressUser,$candidate_choosen);
                Log::error("user dengan member_id : {$memberId}, user_id : {$userId}, bag_id : {$bagIdUser}, ip_address : {$ipAddressUser}, nosis: {$nosisUser} sudah melakukan voting sebelumnya");

                // Redirect the user, sudah pernah melakukan voting
                return redirect()->route('home')->with('user-has-vote', 'Anda sudah melakukan voting sebelumnya');
            } else {
                if($isPilketumPhase){
                    return $next($request);
                } else {
                     // Redirect the user, vote belum dimulai
                    $this->createLogs($bagIdUser,$userHasSubmitDpt->id,$users,"waktu belum dimulai",$ipAddressUser,$candidate_choosen);
                     return redirect()->route('home')->with('vote-has-not-started-yet', 'Maaf voting belum dimulai');
                }
            }
        }


        // Log data string warning
        $this->createLogs($bagIdUser,$userHasSubmitDpt->id,$users,"tidak terdaftar dpt",$ipAddressUser,$candidate_choosen);
        Log::warning("user dengan member_id : {$memberId}, user_id : {$userId}, bag_id : {$bagIdUser}, ip_address : {$ipAddressUser}, nosis: {$nosisUser} tidak terdaftar di DPT");

        // Redirect the user or show an error message
        return redirect()->route('home')->with('not-eligible', 'Maaf akun anda belum memenuhi syarat untuk melakukan vote');
    }

    public function createLogs($bagId,$pilketumVoterId,$users,$susAction,$ipAddress,$candidateChoosen){
        //generate token
        $refkey = Str::random(10); 
        PilketumLogs::create([
            'pilketum_id' => 1,
            'reference_key' => $refkey,
            'vote' => isset($candidateChoosen) ? $candidateChoosen['candidate_number'] : null,
            'vote_at' => Carbon::now(),
            'bag_id' => $bagId,
            'pilketum_voters_id' => $pilketumVoterId,
            'member_id' => $users->member_id,
            'ip_address' => $ipAddress,
            'user_id' => $users->id,
            'status' => $users->status,
            'sus_action' => $susAction,
            'created_at' => Carbon::now()

        ]);
    }
}
