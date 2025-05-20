<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageUploadService
{

    public function upload($file): string
    {
        $extension = strtolower($file->getClientOriginalExtension());

        // Directly handle SVG files
        if ($extension === 'svg') {
            $filename = Str::uuid() . '.svg';
            Storage::putFileAs('public', $file, $filename);
            return $filename;
        }

        // Check if the file is an image
        if (str_starts_with($file->getMimeType(), 'image/')) {
            $manager = new ImageManager(new Driver());
            $image = $manager->read($file);
            $image = $image->toWebp(60);

            $filename = Str::uuid() . '.webp';
            Storage::put('public/' . $filename, (string) $image);

            return $filename;
        }

        // For non-image files like PDFs, store it directly
        $filename = Str::uuid() . '.' . $extension;
        Storage::putFileAs('public', $file, $filename);

        return $filename;
    }




}
