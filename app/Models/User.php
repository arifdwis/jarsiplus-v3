<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Novay\Nue\Traits\HasProfilePhoto;
use Novay\Nue\Traits\DefaultDatetimeFormat;
use Novay\Nue\Traits\HasPermissions;

class User extends Model implements AuthenticatableContract //, MustVerifyEmail
{
    use HasApiTokens, Notifiable;
    use HasProfilePhoto, HasPermissions;
    use DefaultDatetimeFormat;
    use Authenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'uid',
        'photo',
        'name',
        'email',
        'email_verified_at',
        'password',
        'phone',
        'last_login',
        'remember_token',
        'last_ip_address',
        'nickname',
        'address',
        'jenis',
        'unit_id',
        'postal_code',
        'kelurahan_id',
        'level',
        'gender',
        'created_at',
        'date_birth',
        'deleted_at',
        'updated_at',
    ];


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

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'photo_url',
    ];


    public function pemohon()
    {
        return $this->belongsTo('Modules\Pemohon\Entities\Pemohon', 'id', 'id_operator');
    }

    public function corporate()
    {
        return $this->belongsTo('Modules\Pemohon\Entities\Corporate', 'id', 'id_operator');
    }

    public function role_s()
    {
        return $this->hasMany('App\Models\Roles', 'user_id');
    }

    /**
     * Override photo_url - gunakan inisial nama sebagai avatar
     */
    public function getPhotoUrlAttribute()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

}
