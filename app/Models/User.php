<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $primaryKey = 'user_id';

    protected $fillable = [
        'nama',
        'sekolah_id',
        'nomor_telepon',
        'password',
        'api_token',
        'foto',
        'likes',
        'likeByYou'
    ];

    // public function teman(){
    //     return $this->hasMany(Teman::class, "teman_id");
    //  }

     public function sekolah(){
        return $this->belongsTo('App\Models\Sekolah', "sekolah_id");
     }

     public function likes()
     {
         return $this->hasMany(Like::class);
     }

    //  public function like()
    // {
    //     $this->likes_count++;
    //     $this->liked_by_you = true;
    //     $this->save();
    // }

    // public function likedByYou()
    // {
    //     if (!Auth::check()) {
    //         return false;
    //     }
    //     return $this->likes()->where('user_id', Auth::id())->exists();
    // }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    
     // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }



}
