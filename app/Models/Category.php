<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $name
 * @property string $display_name
 * @property string $icon
 * @property Collection<int, Task> $tasks
 */
class Category extends Model
{

    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'name',
        'display_name',
        'icon',
    ];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'category_name', 'name');
    }
}
