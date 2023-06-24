<?php

namespace Modules\Login\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Entities\Brand;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    protected $fillable = [];

    const ROLE_BRAND = 'brand';
    const ROLE_RETAILER = 'retailer';
    const ROLE_SuperAdmin = 'super admin';
    const ROLE_Admin = 'admin';
    const ROLE_Content = 'Content Moderator';

    public function brandDetails()
    {
        return $this->hasOne(Brand::class);
    }
}
