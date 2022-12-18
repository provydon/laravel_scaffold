<?php

namespace App\Services\AllServices;

use Illuminate\Support\Facades\Storage;

class FileService
{
    public static function storeFile($file, $folder, $cloud = false)
    {
        if ($cloud) {
            $path = $file->store($folder, 's3');
        } else {
            // $path = $file->store($folder);
            $path = Storage::disk('public')->put($folder, $file);
        }

        return $path;
    }

    public static function deleteFile($path, $cloud = false)
    {
        if ($cloud) {
            Storage::cloud()->delete($path);
        } else {
            Storage::delete($path);
        }

    }
}

return new FileService;
