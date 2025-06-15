<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Warning extends Model
{
    protected $fillable = ['user_id', 'admin_id', 'message', 'report_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function report()
    {
        return $this->belongsTo(Report::class, 'report_id');
    }
}
