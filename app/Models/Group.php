<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function events()   
    {
        return $this->hasMany(Event::class);  
    }
    
    public function members()   
    {
        return $this->hasMany(Member::class);  
    }
    
    public function orderByGroup()
    {
         return $this->orderBy('updated_at', 'DESC')->get();
    }
    
    public function getByGroup()
    {
         return $this->events()->with('group')->orderBy('updated_at', 'DESC')->get();
    }
    
    protected $fillable = [
        'name',
    ];
}
