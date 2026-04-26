<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadService
{
    /**
     * Upload an image to the configured filesystem (Cloudinary in production)
     *
     * @param UploadedFile $file
     * @param string $folder Folder path (e.g., 'products', 'banners')
     * @param string|null $name Custom filename (without extension)
     * @return string The file path/URL for the stored image
     */
    public static function upload(UploadedFile $file, string $folder = 'uploads', ?string $name = null): string
    {
        $name = $name ?? Str::random(32);
        $filename = $name . '.' . $file->getClientOriginalExtension();
        $path = $folder . '/' . $filename;

        Storage::disk(config('filesystems.default'))->put($path, $file->get());

        return $path;
    }

    /**
     * Get the URL for an uploaded image
     *
     * @param string|null $path The file path stored in the database
     * @return string|null The full URL to the image
     */
    public static function getUrl(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        $disk = config('filesystems.default');
        $filesystem = Storage::disk($disk);

        try {
            if ((string) config("filesystems.disks.{$disk}.driver") === 'cloudinary') {
                // Cloudinary returns URL directly
                return $filesystem->url($path);
            }

            // For local disks
            if ((string) config("filesystems.disks.{$disk}.driver") === 'local') {
                if ($disk === 'public') {
                    return asset('storage/' . $path);
                }
                return route('media.show', ['path' => $path]);
            }

            // For S3 and other cloud storage
            return $filesystem->url($path);
        } catch (\Throwable) {
            return null;
        }
    }

    /**
     * Delete an uploaded image
     *
     * @param string|null $path The file path to delete
     * @return bool
     */
    public static function delete(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        try {
            Storage::disk(config('filesystems.default'))->delete($path);
            return true;
        } catch (\Throwable) {
            return false;
        }
    }

    /**
     * Check if a file exists
     *
     * @param string|null $path The file path to check
     * @return bool
     */
    public static function exists(?string $path): bool
    {
        if (!$path) {
            return false;
        }

        try {
            return Storage::disk(config('filesystems.default'))->exists($path);
        } catch (\Throwable) {
            return false;
        }
    }
}
