<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Artwork extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image',
        'title',
        'price',
        'user_id',
        'sold',
        // 'email',
        // 'password',
    ];

    /**
     * Get the artworks for the user.
     */
    public function user()
    {
        // return $this->hasMany(User::class);
        return $this->belongsTo(User::class, "user_id");
    }

    public function bids()
    {
        // return $this->hasMany(User::class);
        return $this->hasMany(Bid::class);
    }

    public function getFirstbidtimeAttribute()
    {
        $first_bid = $this->bids()->getQuery()->orderBy('created_at', 'desc')->first();
        return $first_bid;
        // if($first_bid)
        //     return $first_bid->created_at;
        // else
        //     return null;
    }

    // public function sellable()
    // {
    //     return date('Y-m-d h:i:s', time() - 86400) > $this->getFirstbidtimeAttribute();
    // }
}
