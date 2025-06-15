<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ban extends Model
{
    protected $fillable = ['user_id', 'admin_id', 'banned_at', 'banned_until', 'reason', 'report_id', 'is_active'];

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
    public function appeals()
    {
        return $this->hasMany(Appeal::class);
    }
}
