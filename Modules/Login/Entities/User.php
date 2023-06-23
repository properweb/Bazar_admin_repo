<?php

namespace Modules\Login\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Entities\Brand;
use Spatie\Permission\Traits\HasRoles;

class User extends Model
{
    use HasRoles;
    protected $fillable = [];

    const ROLE_BRAND = 'brand';
    const ROLE_RETAILER = 'retailer';

    public function brandDetails()
    {
        return $this->hasOne(Brand::class);
    }
}
