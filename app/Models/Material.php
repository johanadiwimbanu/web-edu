<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Material extends Model
{ 
    protected $fillable = [
        'title',
        'type',
        'content',
        'file_path',
        'status',
        'user_id',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->whereNull('parent_id')->latest();
    }
}
