<?php

namespace App\Models;

use Carbon\Carbon;

class Token extends Model
{
    protected string $table_name = 'tokens';

    public function findOrCreateToken($userId)
    {

        $token = $this->where('userId', $userId)->where('expired_at', Carbon::now(), '>')->first();

        if (is_null($token)) {
            $this->resetTokens($this->where('userId', $userId)->all() ?? []);
            $token = $this->create(['userId' => $userId, 'token' => random(10), 'expired_at' => Carbon::now()->addMinutes(2)]);
        }
        return $token;
    }

    public function resetUserOldTokens($userId): static
    {
        $this->resetTokens($this->where('userId', $userId)->all() ?? []);
        return $this;
    }

    public function resetTokens(array $tokens){
        array_map(function($token){
            $token->delete();
        },$tokens);

        return $this;
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

}