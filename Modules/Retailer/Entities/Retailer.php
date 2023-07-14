<?php

namespace Modules\Retailer\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Retailer extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
