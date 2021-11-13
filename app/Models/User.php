<?php

namespace App\Models;

use App\Service\S3Service;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\App;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'profile'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $s3Service;

    public function __construct(){
        $this->s3Service =  App::make(S3Service::class);
    }

    public function setProfileAttribute($value){
        $this->attributes['profile'] = $this->s3Service->uploadFile($value, $this->attributes['email'] . '.png');
    }

    public function getProfileAttribute($value){
        if(isset($value) && !empty($value))
            return $this->s3Service->getUrl($value);
    }
}
