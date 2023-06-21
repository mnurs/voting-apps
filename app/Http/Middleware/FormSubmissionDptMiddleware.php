<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;

use App\Models\PilketumVoter;

class FormSubmissionDptMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $userId = $request->user()->member_id;
        
        $userHasSubmitDpt = PilketumVoter::where('member_id', $userId)->first();

        if ($userHasSubmitDpt && $userHasSubmitDpt->vote_at == null) {
            return $next($request);
        }

        // Redirect the user or show an error message
        return redirect()->route('home');
    }
}