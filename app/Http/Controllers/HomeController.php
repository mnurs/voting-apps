<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Models\PilketumVoter;
use App\Interfaces\PilketumVoterRepositoryInterface;
use App\Interfaces\PilketumRepositoryInterface;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{

    protected $pilketumRepository;
    protected $pilketumVoterRepository;

    protected $pilketumIdNow;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(PilketumVoterRepositoryInterface $pilketumVoterRepository, PilketumRepositoryInterface $pilketumRepository)
    {
        $this->middleware(['auth']);

        $this->pilketumRepository = $pilketumRepository;
        $this->pilketumVoterRepository = $pilketumVoterRepository;

        $this->pilketumIdNow = 1;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::check()) {
            $users = auth()->user();

            $pilketums = $this->pilketumRepository->getPilketumById($this->pilketumIdNow) ?? null;
            $startPilketum = $pilketums->start_at;
            $endPilketum = $pilketums->end_at;

            $btnVote = false;
            // $btnRsvp = true; activevate this after fase DPT is end
            $btnDpt = true;

            $hasRegistDpt = $this->pilketumVoterRepository->checkPilketumVoterHasRegis($users->member_id) ?? null;
            $hasRsvp = DB::table('pilketum_rsvps')->where('is_attend', 'N')->where('member_id', $users->member_id)->first();
            $hasVote = $this->pilketumVoterRepository->checkPilketumVoterHasVote($users->member_id) ?? null;

            // kalau udah daftar dpt maka hilangkan button dpt 
            if ($hasRegistDpt) {
                $btnDpt = false;
            } else {
                $btnDpt = true;
            }

            if (empty($hasRsvp)) {
                $btnRsvp = false; // activevate this to true, after fase DPT is end
            } else {
                $btnRsvp = false;
            }

            // jika sudah mulai voting
            if (Carbon::now() >= $startPilketum && Carbon::now() <= $endPilketum) {
                $btnVote = true;
            }

            //  kalau udah nge vote maka btn vote hilang
            if ($hasVote) {
                $btnVote = false;
            }

            //  kalau udah abis masa DPT, Hide tombol DPT untuk semua user
            if (Carbon::now() >= '2023-06-22 14:00:00'){
                $btnDpt = false;
            }

            return view('home', compact('users', 'btnDpt', 'btnVote', 'btnRsvp', 'startPilketum', 'endPilketum', 'hasVote'));
        }

        return redirect('/')->withSuccess('You are not allowed to access');
    }
}
