<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MemberEventPaid extends Model
{
    use HasFactory;
    use SoftDeletes;
    
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
    ];
}
