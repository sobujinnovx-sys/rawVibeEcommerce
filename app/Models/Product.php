<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $appends = ['image_url', 'has_discount', 'discount_percentage', 'effective_price'];

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'price',
        'discount_price',
        'promo_label',
        'image',
        'stock',
        'description',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        $disk = $this->imageDisk();

        if ((string) config("filesystems.disks.{$disk}.driver") === 'local') {
            return $disk === 'public'
                ? asset('storage/'.$this->image)
                : route('media.show', ['path' => $this->image]);
        }

        /** @var \Illuminate\Filesystem\FilesystemAdapter $filesystem */
        $filesystem = Storage::disk($disk);

        return $filesystem->url($this->image);
    }

    public function imageDisk(): string
    {
        return (string) config('filesystems.image_upload_disk', config('filesystems.product_upload_disk', 'public'));
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->discount_price !== null && (float) $this->discount_price > 0 && (float) $this->discount_price < (float) $this->price;
    }

    public function getDiscountPercentageAttribute(): int
    {
        if (!$this->has_discount) {
            return 0;
        }

        $discountRatio = 1 - (((float) $this->discount_price) / ((float) $this->price));

        return (int) round($discountRatio * 100);
    }

    public function getEffectivePriceAttribute(): float
    {
        return $this->has_discount ? (float) $this->discount_price : (float) $this->price;
    }
}
