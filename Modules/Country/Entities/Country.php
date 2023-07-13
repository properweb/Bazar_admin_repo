<?php

namespace Modules\Country\Entities;

use Illuminate\Database\Eloquent\Model;


class Country extends Model
{
    protected $fillable = [];
    public function states()
    {
        return $this->hasMany(State::class);
    }
}
