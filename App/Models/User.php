<?php

namespace App\Models;

use Carbon\Carbon;

class User extends Model
{
    protected string $table_name = 'users';

    public function userHasActiveToken(): bool
    {
        if ((new Token())->where('userId',$this->id)->first()->expired_at >= Carbon::now()){
            return true;
        }
        return false;
    }

    public function articles(){
       return $this->hasMany(Article::class);
    }

    public function tokens(){
        return $this->hasMany(Token::class);
    }

    public function permissions(): array
    {
        return $this->belongsToMany(Permission::class);
    }
}