<?php

namespace Modules\Country\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class City extends Model
{
    use HasFactory;

    protected $fillable = [];

    protected static function newFactory()
    {
        return \Modules\Country\Database\factories\CityFactory::new();
    }
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
