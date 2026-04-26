<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Cloudinary Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your Cloudinary settings. The Cloudinary URL
    | should be set via the CLOUDINARY_URL environment variable.
    |
    */

    'url' => env('CLOUDINARY_URL'),

    /*
    |--------------------------------------------------------------------------
    | Disk Configuration
    |--------------------------------------------------------------------------
    |
    | Configure the Cloudinary disk for file uploads
    |
    */

    'disk' => 'cloudinary',

    /*
    |--------------------------------------------------------------------------
    | Upload Folder
    |--------------------------------------------------------------------------
    |
    | The default folder where uploaded files will be stored
    |
    */

    'folder' => env('CLOUDINARY_FOLDER', 'raw-vibe'),

    /*
    |--------------------------------------------------------------------------
    | Quality Settings
    |--------------------------------------------------------------------------
    |
    | Configure default quality for image transformations
    |
    */

    'quality' => 'auto',

    /*
    |--------------------------------------------------------------------------
    | Fetch Format
    |--------------------------------------------------------------------------
    |
    | Default fetch format for images
    |
    */

    'fetch_format' => 'auto',
];
