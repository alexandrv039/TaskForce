<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $name
 * @property string $icon
 * @property Task[] $tasks
 */
class Category extends Model
{
    protected $fillable = [
        'name',
        'icon',
    ];

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class, 'category', 'name');
    }
}
