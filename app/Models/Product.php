<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Product
 *
 * @package App\Models
 *
 * @property int $id
 * @property string $original_id
 * @property string $name
 * @property string $image_url
 * @property Category $categories
 */
class Product extends Model
{
    use HasFactory;

    protected $fillable = ['original_id', 'name', 'image_url'];

    public function categories() {
        return $this->belongsToMany(Category::class);
    }
}
