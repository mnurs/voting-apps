<?php

namespace App\Http\Controllers;

use App\Interfaces\MemberRepositoryInterface;
use App\Interfaces\PilketumRepositoryInterface;
use App\Mail\PilketumRsvpMailer;
use App\Models\PilketumRsvp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;

class ReservationController extends Controller
{

    protected $memberRepository;
    protected $pilketumRepository;

    protected $pilketumIdNow;

    public function __construct(MemberRepositoryInterface $memberRepository, PilketumRepositoryInterface $pilketumRepository) 
    {
        $this->memberRepository = $memberRepository;
        $this->pilketumRepository = $pilketumRepository;

        // change this later (for dynamicly data)
        $this->pilketumIdNow = 1;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $users = auth()->user(); 
        $member_id = $users->member_id;
        
        $member = $this->memberRepository->getMemberById($member_id);
        $memberBatch = $this->memberRepository->getMemberBatchNameById($member_id);
        
        return view('rsvp', compact('member', 'memberBatch'));
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
        $member = $this->memberRepository->getMemberById($users->member_id);        
        $memberBatch = $this->memberRepository->getMemberBatchNameById($users->member_id);

        $member_id = $users->member_id;


        $messages = [
            'required' => 'Field :attribute is required',
        ];

        $request->validate([
            'no_whatsapp' => 'required',
            'email' => 'required',
            'rsvp_photo' => 'required',
        ], $messages);

        $fileName = 'rsvp_' . auth()->user()->member_id . '_' . time() . '.'. $request->rsvp_photo->extension();  

        $request->rsvp_photo->move(public_path('uploads/rsvp'), $fileName);
        

        // generate QR Code
        // hide generate code dan memberid
        // $codeRsvp = Str::random(10) . '_' . $member_id;
        $codeRsvp = Str::random(10) . '_' . $member_id;

        // $url = request()->secure() ? 'https://' . request()->getHost() : 'http://' . request()->getHost();

        // tes buat hardcode
        // $urlAttendRsvp = $url . "/attend_rsvp/{$codeRsvp}";
        
        //  ganti ke member id ketika di scan qr 
        $member_id_qr = strval($member_id);

        $writer = new Writer(new Png());
        $imageQrRsvp = $writer->writeString($member_id_qr);

         // insert data to db
         $saved = PilketumRsvp::create([
            'pilketum_id' => $pilketum->id,
            'member_id' => $users->member_id,
            'no_whatsapp' => $request->no_whatsapp,
            'email' => $request->email,
            'photo' => $fileName,
            'rsvp_code' => $codeRsvp,
            'is_attend' => 'N',
        ]);
        
        $member_name = $member->name;
        $member_nosis = $member->nosis;
        $member_batch = $memberBatch->batch_name;

        if ($saved) {
            // kirim email ke voters
            Mail::to($request->email)->send(new PilketumRsvpMailer($member_name, $member_nosis, $member_batch, $imageQrRsvp));
            return redirect()->route('rsvp_success');
        } else {
            App::abort(500, 'Maaf ada beberapa kesalahan server');
        }
        
    }


    public function rsvp_success()
    {
        $users = auth()->user();
        $member_id = strval($users->member_id);

        $writer = new Writer(new Png());
        $imageQrRsvp = $writer->writeString($member_id);

        return view('thankyou_rsvp', compact('imageQrRsvp'));
    }


    public function rsvp_attendance(Request $request)
    {
        $codeRsvp = $request->code_rsvp;

        $updated = PilketumRsvp::where('pilketum_id', $this->pilketumIdNow)
            ->where('rsvp_code', $codeRsvp)
            ->update([
                'is_attend' => "Y",
            ]);

        $users = auth()->user(); 
        return redirect()->route('home');
    }

}
