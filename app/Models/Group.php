<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    
    public function events()   
    {
        return $this->hasMany(Event::class);  
    }
    
    public function members()   
    {
        return $this->hasMany(Member::class);  
    }
}
