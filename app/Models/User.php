<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Member;

class User extends Authenticatable
{

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password', 'role', 'member_id', 'member_name', 'batch_name', 'member_nosis', 'photo', 'status', 'last_login', 'verification_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Set the verified status to true and make the email token null
    public function verified()
    {
        $status = 'member_unverified';
        //auto approve if name and batch match, and is_graduate and decease_date null
        $member = Member::where('nosis', $this->member_nosis)->first();
        $batch = \App\Batch::where('name', $this->batch_name)->first();

        if (strtoupper(trim($member->name)) == strtoupper(trim($this->member_name)) && $batch->id == $member->batch_id && $member->is_graduate && empty($member->decease_date)) {
            $status = 'active';
            $this->member_name = strtoupper($member->name);
        }

        $this->status = $status;
        $this->verification_token = null;

        $this->save();

        return $this;
    }

    public function isAdmin()
    {
        if ($this->role == 'superadmin' || $this->role == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    public function member()
    {
        return $this->belongsTo('App\Models\Member', 'member_id');
    }
}
