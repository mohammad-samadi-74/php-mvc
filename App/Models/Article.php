<?php

namespace App\Models;

class Article extends Model
{
    protected string $table_name = 'articles';

    public function user(){
        return $this->belongsTo(User::class);
    }
}