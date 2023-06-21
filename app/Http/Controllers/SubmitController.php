<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Email;
use App\Phone;
use App\Pilketum_voter;
use App\Rsvp;
use BaconQrCode\Renderer\Image\Png;
use BaconQrCode\Writer;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Session;

class SubmitController extends Controller
{
    public function updateEmail(Request $request)
    {
        $memberId = strval($request->member_id());
        $email = strval($request->email());
        $existingEmail = Email::where('email', $email)->first();
        if(!$existingEmail){
            Email::create([
                'member_id' => $memberId,
                'email' => $email]);
        }
    }
    public function updatePhone(Request $request)
    {
        $memberId = strval($request->member_id());
        $phone = strval($request->phone());
        $existingPhone = Email::where('phone', $phone)->first();
        if(!$existingPhone){
            Email::create([
                'member_id' => $memberId,
                'phone' => $phone]);
        }
    }

    public function sendEmailEvoting(Request $request)
    {
        $email = strval($request->email());
        $subject = strval($request->subject());
        $memberName = $request->member_name();
        $pilketumTitle = $request->pilketum_title();
        $refkey = $request->refkey(); 
        $data = [
            'member_name' => $memberName,
            'pilketum_title' => $pilketumTitle,
            'refkey' => $refkey
        ];
        Mail::send('emails.pilketumvote', $data, function ($message) use ($email, $subject) {
            $message->to($email);
            $message->subject($subject);
        });
    }

    public function sendEmailRsvp(Request $request)
    {
        $email = strval($request->email);
        $subject = strval($request->subject);
        $memberId = strval($request->member_id);
        $title = strval($request->title);
        $place = strval($request->place);
        $date = strval($request->date);
        $time = strval($request->time);

        $writer = new Writer(new Png());

        $data = 'http://database.ikastara.or.id/rsvp/attendance/{$memberId}';

        $imageData = $writer->writeString($data);

        $data = [
            'title' => $title,
            'place' => $place,
            'date' => $date,
            'time' => $time
        ];
        Mail::send('emails.rsvp', $data, function ($message) use ($email, $subject,$imageData) {
            $message->to($email);
            $message->subject($subject);
        });
    }

}