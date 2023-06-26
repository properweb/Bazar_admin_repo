<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Modules\Brand\Entities\Brand;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Models\Role;


class User extends Authenticatable
{
    use Notifiable,HasRoles;
    use SoftDeletes;

    const ROLE_BRAND = 'brand';
    const ROLE_RETAILER = 'retailer';
    const ROLE_SUPER = 'super admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_CONTENT = 'Content Moderator';

    public function brandDetails()
    {
        return $this->hasOne(Brand::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
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
}
