<?php

namespace Modules\Role\Entities;

use Illuminate\Database\Eloquent\Model;


class Page extends Model
{
    protected $fillable = [];

    public function parent()
    {
        return $this->belongsTo(Page::class, 'id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id');
    }
}
