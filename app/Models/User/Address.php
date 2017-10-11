<?php

namespace App\Models\User;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'demo_user_address';

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
