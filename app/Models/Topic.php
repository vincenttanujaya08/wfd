<?php namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug'];

    // Relationships
    public function posts()
    {
        // Assumes pivot table 'post_topic' with columns 'post_id' and 'topic_id'
        return $this->belongsToMany(Post::class, 'post_topic', 'topic_id', 'post_id');
    }
}
