<?php

namespace App\Services\AllServices;

use Illuminate\Support\Facades\Storage;

class FileService
{

    public static function storeFile($file, $folder, $cloud = true)
    {

        if ($cloud) {
            $path = $file->store($folder, 's3');
        } else {
            // $path = $file->store($folder);
            $path = Storage::disk('public')->put($folder, $file);
        }

        return $path;
    }
}

return new FileService;
