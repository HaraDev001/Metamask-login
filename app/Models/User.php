<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\Artwork;
use App\Models\Bid;
// use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable implements JWTSubject
{
    // use HasFactory;
       /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    
    use HasFactory, Notifiable;
    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        // 'name',
        'publicAddress',
        'nonce',
        // 'email',
        // 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        // 'password',
        'remember_token',
    ];
    
    /**
     * Get the artworks of user.
     */
    public function artworks()
    {
        // return $this->belongsTo(Artwork::class ,"user_id");
        return $this->hasMany(Artwork::class);
    }

    /**
     * Get the bids of user.
     */
    public function bids()
    {
        // return $this->belongsTo(Artwork::class ,"user_id");
        return $this->hasMany(Bid::class);
    }

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
