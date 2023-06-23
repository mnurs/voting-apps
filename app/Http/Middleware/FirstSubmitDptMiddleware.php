<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

use App\Models\PilketumVoter;
use App\Models\User;
use Carbon\Carbon;

class FirstSubmitDptMiddleware
{

    // Middleware untuk mencegah user isi DPT 2 kali. Hanya untuk pertama kali isi

    public function handle(Request $request, Closure $next)
    {
        $userId = $request->user()->member_id;
        
        $userHasSubmitDpt = PilketumVoter::where('member_id', $userId)->where('vote_at', null)->first();
        $isRegistDptPhase = (Carbon::now() <= '2023-06-22 09:00:00') ? true : false;

        // khusus untuk user yang belum daftar dpt
        if (empty($userHasSubmitDpt)) {
            if($isRegistDptPhase){
                return $next($request);
            } else {
                 // Redirect the user, pendaftaran dpt sudah berakhir
                 return redirect()->route('home')->with('time-dpt-has-expired', 'Maaf waktu pendaftaran DPT telah berakhir');
            }
            return $next($request);
        }

        // Redirect the user or show an error message
        return redirect()->route('home')->with('not-eligible', 'Maaf akun anda belum memenuhi syarat untuk melakukan pengisian DPT');
    }
}