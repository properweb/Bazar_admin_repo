<?php

namespace Modules\Brand\Entities;

use Illuminate\Database\Eloquent\Model;


class Brand extends Model
{
    protected $fillable = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
