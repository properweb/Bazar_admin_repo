<?php

namespace Modules\Login\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Entities\Brand;

class User extends Model
{

    protected $fillable = [];
    const ROLE_BRAND = 'brand';
    const ROLE_RETAILER = 'retailer';

    public function brandDetails()
    {
        return $this->hasOne(Brand::class);
    }

}
