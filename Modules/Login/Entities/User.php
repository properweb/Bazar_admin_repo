<?php

namespace Modules\Login\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Entities\Brand;
use Modules\Retailer\Entities\Retailer;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasRoles;
    use SoftDeletes;
    protected $fillable = [];

    const ROLE_BRAND = 'brand';
    const ROLE_RETAILER = 'retailer';
    const ROLE_SUPER_ADMIN = 'super admin';
    const ROLE_ADMIN = 'admin';
    const ROLE_CONTENT_ADMIN = 'Content Moderator';
    const ROLE_ID_SUPER_ADMIN = 1;

    public function brandDetails()
    {
        return $this->hasOne(Brand::class);
    }
    public function retailerDetails()
    {
        return $this->hasOne(Retailer::class);
    }

}
