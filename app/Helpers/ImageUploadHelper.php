<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ImageUploadHelper
{
    public static function upload($file, $folder, $allowedExtensions)
    {
        $allowedfileExtension = $allowedExtensions;
        $extension = $file->getClientOriginalExtension();

        if (in_array($extension, $allowedfileExtension)) {
            $imageName = time() . '.' . $extension;
            Storage::disk('public')->putFileAs($folder, $file, $imageName);
            return $imageName;
        }
        return null;
    }
}
