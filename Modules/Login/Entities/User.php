<?php

namespace Modules\Login\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Brand\Entities\Brand;

class User extends Model
{


    protected $fillable = [];

    public function brandDetails()
    {
        return $this->hasOne(Brand::class);
    }

}
