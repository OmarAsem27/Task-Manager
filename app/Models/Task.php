<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'status',
        'user_id'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'task_category');
    }
    public function category($name)
    {
        $category = Category::firstOrCreate(['name' => $name]);
        $this->categories()->attach($category);
    }
}
