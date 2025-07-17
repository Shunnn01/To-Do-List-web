<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
protected $fillable = ['name', 'deadline', 'priority', 'is_done', 'user_id'];

public function user()
{
    return $this->belongsTo(User::class);
}

}

