<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Hapus topik yang tidak memiliki postingan terkait
        DB::table('topics')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('post_topic')
                    ->whereColumn('post_topic.topic_id', 'topics.id');
            })
            ->delete();
    }

    public function down()
    {
        
    }
};
