<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

use App\Models\PilketumVoter;
use App\Models\Pilketum;
use Carbon\Carbon;

class FormSubmissionDptMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->user()->member_id;

        $pilketum = Pilketum::latest('id')->first();
        $isPilketumPhase = (Carbon::now() >= $pilketum->start_at && Carbon::now() <= $pilketum->end_at) ? true : false; 

        $userHasSubmitDpt = PilketumVoter::where('member_id', $userId)->first();

        if ($userHasSubmitDpt && $userHasSubmitDpt->vote_at == null) {
            if($isPilketumPhase){
                return $next($request);
            }
        }

        // Redirect the user or show an error message
        return redirect()->route('home');
    }
}
