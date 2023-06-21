<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

use App\Models\PilketumVoter;

class FirstSubmitDptMiddleware
{

    // Middleware untuk mencegah user isi DPT 2 kali. Hanya untuk pertama kali isi

    public function handle(Request $request, Closure $next)
    {
        $userId = $request->user()->member_id;
        
        $userHasSubmitDpt = PilketumVoter::where('member_id', $userId)->where('vote_at', null)->first();

        // khusus untuk user yang belum daftar dpt
        if (empty($userHasSubmitDpt)) {
            return $next($request);
        }

        // Redirect the user or show an error message
        return redirect()->route('home');
    }
}