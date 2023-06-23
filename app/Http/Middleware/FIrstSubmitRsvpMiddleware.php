<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

use App\Models\PilketumRsvp;
use App\Models\User;

class FirstSubmitRsvpMiddleware
{

    // Middleware untuk mencegah user isi RSVP 2 kali. Hanya untuk pertama kali isi

    public function handle(Request $request, Closure $next)
    {
        $userId = $request->user()->member_id;
        
        $userHasSubmitRsvp = PilketumRsvp::where('member_id', $userId)->first();

        // khusus untuk user yang belum daftar rsvp munas
        if (empty($userHasSubmitRsvp)) {
            return $next($request);
        }

        // Redirect the user or show an error message
        return redirect()->route('home')->with('not-eligible', 'Maaf akun anda belum memenuhi syarat untuk melakukan rsvp');
    }
}