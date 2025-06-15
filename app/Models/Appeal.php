<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appeal extends Model
{
    protected $fillable = ['ban_id', 'user_id', 'message', 'status'];

    public function ban()
    {
        return $this->belongsTo(Ban::class, 'ban_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
