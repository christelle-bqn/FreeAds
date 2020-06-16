<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement extends Model
{
    protected $fillable = [
        'title', 'description', 'photos', 'price', 'city', 'category_id',
    ];

    public function user()
    { 
        return $this->belongsTo(User::class); 
    }

    public function category()
    { 
        return $this->belongsTo(Category::class)->withTimestamps();; 
    }
}
