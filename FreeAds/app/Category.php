<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /* protected $fillable = [
        'name',
    ]; */

    protected $guarded = [];  

    public function advertisements() 
    { 
        return $this->hasMany(Advertisement::class); 
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
