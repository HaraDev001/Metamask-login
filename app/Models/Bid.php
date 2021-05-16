<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    public function user()
    {
        // return $this->hasMany(User::class);
        return $this->belongsTo(User::class, "user_id");
    }

    public function artwork()
    {
        // return $this->hasMany(User::class);
        return $this->belongsTo(Artwork::class, "artwork_id");
    }
}
