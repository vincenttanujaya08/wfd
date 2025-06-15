<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
        'reporter_id',
        'reported_user_id',
        'description',
        'status',
        'handled_by_admin_id',
        'handled_at'
    ];

    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }
    public function reportedUser()
    {
        return $this->belongsTo(User::class, 'reported_user_id');
    }
    public function handledByAdmin()
    {
        return $this->belongsTo(User::class, 'handled_by_admin_id');
    }
    public function images()
    {
        return $this->hasMany(ReportImage::class);
    }
}
