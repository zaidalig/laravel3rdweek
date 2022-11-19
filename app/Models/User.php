<?php

namespace App\Models;

use App\Models\UserUploadImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use App\Models\UserVerify;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'confirm_password',
        'image',
        'is_email_verified'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'confirm_password',
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
    public function UserUploadedImage()
    {
        return $this->hasMany(UserUploadImage::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
    public function verifyUser(){
         return $this->hasOne('App\Models\VerifyUser');
        }


}
