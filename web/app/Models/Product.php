<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'code',
        'short_description',
        'long_description',
        'features',
        'specifications',
        'min_order_qty',
        'lead_time_days',
        'icon',
        'thumbnail',
        'gallery',
        'meta_title',
        'meta_description',
        'is_published',
        'sort_order',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'features' => 'array',
            'specifications' => 'array',
            'gallery' => 'array',
            'is_published' => 'boolean',
            'sort_order' => 'integer',
            'published_at' => 'datetime',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id');
    }

    public function applicationAreas(): BelongsToMany
    {
        return $this->belongsToMany(ApplicationArea::class, 'application_product')
            ->withPivot('note', 'sort_order')
            ->withTimestamps();
    }

    public function relatedProducts(): BelongsToMany
    {
        return $this->belongsToMany(self::class, 'product_related', 'product_id', 'related_product_id')
            ->withPivot('sort_order')
            ->withTimestamps();
    }
}
