<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class Helper
{

    public static function apiRes($message, $data = [], $status = true, $code = 200)
    {
        return response()->json([
            "success" => $status,
            "message" => $message,
            "data" => $data,
        ], $code);
    }

    public static function prepareThumbnail($image)
    {

        $thumbSize = 300;

        $image_thumb = Image::make($image)->fit($thumbSize);

        $ext = "." . explode("/", $image_thumb->mime())[1];
        $fileNameThumb = "thumbnails/" . md5(time()) . time() . $ext;

        $image_thumb = $image_thumb->stream();

        Storage::put($fileNameThumb, $image_thumb->__toString());

        return [
            'thumbnail' => $fileNameThumb,
        ];
    }
}
