<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberEventPay extends Model
{
    use HasFactory;
    
    public function member()   
    {
        return $this->belongsTo(Member::class);  
    }
    
    public function event()   
    {
        return $this->belongsTo(Event::class);  
    }
    
    protected $fillable = [
        'event_id',
        'member_id',
        'amount',
    ];
}
