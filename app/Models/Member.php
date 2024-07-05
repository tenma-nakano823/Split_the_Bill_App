<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function group()   
    {
        return $this->belongsTo(Group::class);  
    }
    
    public function user()   
    {
        return $this->belongsTo(User::class);  
    }
    
    public function memberEventPays()   
    {
        return $this->hasMany(MemberEventPay::class);  
    }
    
    public function memberEventPaids()   
    {
        return $this->hasMany(MemberEventPaid::class);  
    }
    
    protected $fillable = [
        'group_id',
        'user_id',
        'lend',
        'borrow',
        'name',
    ];
}
