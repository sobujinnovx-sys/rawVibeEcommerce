<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Throwable;

class CarouselBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        $disk = $this->imageDisk();
        /** @var \Illuminate\Filesystem\FilesystemAdapter $filesystem */
        $filesystem = Storage::disk($disk);

        try {
            if (!$filesystem->exists($this->image)) {
                return null;
            }
        } catch (Throwable) {
            return null;
        }

        if ((string) config("filesystems.disks.{$disk}.driver") === 'local') {
            return $disk === 'public'
                ? asset('storage/'.$this->image)
                : route('media.show', ['path' => $this->image]);
        }

        return $filesystem->url($this->image);
    }

    public function imageDisk(): string
    {
        return (string) config('filesystems.image_upload_disk', config('filesystems.product_upload_disk', 'public'));
    }
}
