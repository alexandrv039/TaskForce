<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    protected $fillable = [
        'name',
        'lat',
        'lng',
    ];

    public $timestamps = false;

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

}
