<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LandingPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'slug',
        'builder_type',
        'content',
        'thank_you_content',
        'custom_html',
        'custom_css',
        'custom_js',
        'status',
        'seo_title',
        'seo_description',
        'og_image',
        'fb_pixel_id',
        'tiktok_pixel_id',
        'gtm_id',
        'views_count',
        'orders_count',
        'revenue_total',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'views_count' => 'integer',
            'orders_count' => 'integer',
            'revenue_total' => 'decimal:2',
        ];
    }

    protected $appends = ['conversion_rate'];

    public function getConversionRateAttribute(): float
    {
        if ($this->views_count > 0) {
            return round(($this->orders_count / $this->views_count) * 100, 2);
        }

        return 0.00;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(LandingPageVisit::class);
    }

    public function versions(): HasMany
    {
        return $this->hasMany(LandingPageVersion::class);
    }
}
