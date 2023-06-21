<?php

namespace App\Http\Controllers;

use App\Interfaces\CandidateRepositoryInterface;
use App\Interfaces\MemberRepositoryInterface;
use App\Interfaces\PilketumRepositoryInterface;
use App\Mail\PilketumVoteMailer;
use App\Models\PilketumVote;
use App\Models\PilketumVoter;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class VoteController extends Controller
{

    protected $candidateRepository;
    protected $memberRepository;
    protected $pilketumRepository;

    protected $pilketumIdNow;

    public function __construct(CandidateRepositoryInterface $candidateRepository, MemberRepositoryInterface $memberRepository, PilketumRepositoryInterface $pilketumRepository)
    {
        $this->candidateRepository = $candidateRepository;
        $this->memberRepository = $memberRepository;
        $this->pilketumRepository = $pilketumRepository;

        // change this later (for dynamicly data)
        $this->pilketumIdNow = 1;
    }

    /**
     * Display a listing of candidates.
     *
     * @return \Illuminate\Http\Response
     */
    public function vote_candidate()
    {
        if (Session::has('voteinfo')) {
            $candidateChoosen = Session::get('vote.candidate_choosen');
        }

        $candidates = $this->candidateRepository->getPilketumCandidatesInfo($this->pilketumIdNow);
        return view('vote', compact('candidates'));
    }

    /**
     * Store of candidates to session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function vote_candidate_store(Request $request)
    {
        $users = auth()->user();

        $member = $this->memberRepository->getMemberById($users->member_id);
        $memberBatchName = $this->memberRepository->getMemberBatchNameById($users->member_id);

        $candidateId = $request->vote_ketum;
        $candidateInfo = $this->candidateRepository->getCandidateInfo($candidateId);

        $sessionVote = [
            'candidate_choosen' => [
                'candidate_id' => $candidateId,
                'pilketum_id' => $candidateInfo->pilketum_id,
                'candidate_name' => $candidateInfo->name,
                'candidate_batchname' => $candidateInfo->candidate_batch,
                'candidate_number' => $candidateInfo->candidate_number,
                'candidate_member_id' => $candidateInfo->member_id,
                'candidate_photo' => $candidateInfo->photo
            ],
            'voter' => [
                'voter_member_id' => $users->member_id,
                'voter_nosis' => $member->nosis,
                'voter_name' => $member->name,
                'voter_batch' => $memberBatchName->batch_name,
            ]

        ];

        // Session is not empty
        Session::put('voteinfo', $sessionVote);
        return redirect()->route('vote_confirmation');
    }

    /**
     * Show the form for creating a new resource.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function vote_confirmation(Request $request)
    {
        if (Session::has('voteinfo')) {
            $voteinfo = $request->session()->get('voteinfo');
            return view('submit', compact('voteinfo'));
        } else {
            return redirect()->route('vote_candidate')->with('not_yet_choose_candidate', 'Kamu belum memilih kandidat, silahkan pilih terlebih dahulu');
        }
    }

    /**
     * Store a newly created resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function vote_submit(Request $request)
    {

        $users = auth()->user();

        $pilketum = $this->pilketumRepository->getPilketumById($this->pilketumIdNow);
        $pilketumTitle = $pilketum->title;

        $candidate_choosen = $request->session()->get('voteinfo.candidate_choosen');
        $voter = $request->session()->get('voteinfo.voter');

        $messages = [
            'required' => 'Field :attribute is required',
        ];

        $request->validate([
            'no_whatsapp' => 'required',
            'email' => 'required',
            'vote_photo' => 'required',
        ], $messages);

        // file upload
        $fileName = 'votephoto_' . auth()->user()->member_id . '_' . time() . '.' . $request->vote_photo->extension();
        $request->vote_photo->move(public_path('uploads/pilketum/' . $pilketum->id . '/votephoto' . '/'), $fileName);

        //generate token
        $refkey = Str::random(10);

        // insert data to db
        PilketumVote::create([
            'pilketum_id' => $this->pilketumIdNow,
            'reference_key' => $refkey,
            'vote' => $candidate_choosen['candidate_number'],
            'vote_at' => Carbon::now(),
        ]);


        $updated = PilketumVoter::where('member_id', $users->member_id)
            ->where('pilketum_id', $this->pilketumIdNow)
            ->update([
                'vote_at' => Carbon::now(), 'vote_no_whatsapp' => $request->no_whatsapp, 'vote_email' => $request->email, 'vote_photo' => $fileName,
                'updated_by' => $users->member_id,
            ]);

        if ($updated) {
            // kirim email ke voters
            Mail::to($request->email)->send(new PilketumVoteMailer($voter, $candidate_choosen, $refkey, $pilketumTitle));
            return redirect()->route('vote_success');
        } else {
            App::abort(500, 'Maaf ada beberapa kesalahan server');
        }
    }
}
