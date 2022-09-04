<?php

namespace App\Models;

class Permission extends Model
{
    protected string $table_name = 'permissions';

    public function users(): array
    {
        return $this->belongsToMany(User::class,);
    }
}