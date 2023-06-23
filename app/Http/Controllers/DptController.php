<?php

namespace App\Http\Controllers;

use App\Interfaces\MemberRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\PilketumRepositoryInterface;
use App\Models\PilketumVoter;
use App\Mail\PilketumDptMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class DptController extends Controller
{
    
    protected $memberRepository;
    protected $userRepository;
    protected $pilketumRepository;

    protected $pilketumIdNow;

    public function __construct(MemberRepositoryInterface $memberRepository, UserRepositoryInterface $userRepository, PilketumRepositoryInterface $pilketumRepository) 
    {
        $this->memberRepository = $memberRepository;
        $this->userRepository = $userRepository;
        $this->pilketumRepository = $pilketumRepository;

        // change this later (for dynamicly data)
        $this->pilketumIdNow = 1;
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = auth()->user(); 
        $member_id = $users->member_id;
        
        $member = $this->memberRepository->getMemberById($member_id);
        $batch_name = $this->memberRepository->getMemberBatchNameById($member_id)->batch_name;

        return view('dpt', compact('member', 'batch_name'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $users = auth()->user();

        $pilketum = $this->pilketumRepository->getPilketumById($this->pilketumIdNow);

        $messages = [
            'required' => 'Field :attribute is required',
        ];

        $request->validate([
            'no_whatsapp' => 'required',
            'email' => 'required',
            'dpt_photo' => ['required', 'file', 'image'],
        ], $messages);

        $fileName = 'dpt_' . auth()->user()->member_id . '_' . time() . '.'. $request->dpt_photo->extension();  

        $request->dpt_photo->move(public_path('uploads/dpt'), $fileName);

         // insert data to db
         $saved = PilketumVoter::create([
            'pilketum_id' => $pilketum->id,
            'member_id' => $users->member_id,
            'vote_at' => null,
            'no_whatsapp' => $request->no_whatsapp,
            'email' => $request->email,
            'dpt_photo' => $fileName,
        ]);

        $members = [
            'member_name' => $users->member_name,
            'member_nosis' => $users->member_nosis,
            'member_batch' => $users->batch_name,
        ];

        if ($saved) {
            // kirim email ke voters 
            try { 
                Mail::to($request->email)->send(new PilketumDptMailer($members));
             } catch (\Exception $e) {
                 Log::error($e->getMessage()); 
             } 
            return redirect()->route('dpt_success');
        } else {
            App::abort(500, 'Maaf ada beberapa kesalahan server');
        }
        
    }


}
