<?php

namespace App\Http\Controllers;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function __invoke(string $path): Response
    {
        $disk = (string) config('filesystems.image_upload_disk', config('filesystems.product_upload_disk', 'public'));

        abort_if((string) config("filesystems.disks.{$disk}.driver") !== 'local', 404);

        /** @var FilesystemAdapter $filesystem */
        $filesystem = Storage::disk($disk);

        abort_unless($filesystem->exists($path), 404);

        return response()->file($filesystem->path($path), [
            'Content-Type' => $filesystem->mimeType($path) ?? 'application/octet-stream',
        ]);
    }
}