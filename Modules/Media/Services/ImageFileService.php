<?php

namespace Modules\Media\Services;


use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Modules\Media\Contracts\FileServiceContract;
use Modules\Media\Models\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;


class ImageFileService extends DefaultFileService implements FileServiceContract
{
    /**
     * @var array|string[]
     */
    protected static array $sizes = ['300', '600'];

    /**
     * upload file
     *
     * @param UploadedFile $file
     * @param              $filename
     * @param              $dir
     *
     * @return array
     */
    public static function upload(UploadedFile $file, $filename, $dir): array
    {
        Storage::putFileAs($dir, $file, $filename . '.' . $file->getClientOriginalExtension());
        $path = $dir . $filename . '.' . $file->getClientOriginalExtension();
        return self::resize(Storage::path($path), $dir, $filename, $file->getClientOriginalExtension());
    }

    /**
     * @param $img
     * @param $dir
     * @param $filename
     * @param $extension
     *
     * @return array
     */
    private static function resize($image, $dir, $filename, $extension): array
    {
        $img              = new ImageManager(new Driver());
        $img              = $img->read($image);
        $imgs['original'] = $filename . '.' . $extension;
        foreach (self::$sizes as $size) {
            $imgs[$size] = $filename . '_' . $size . '.' . $extension;
            $img->resize($size, null, function ($aspect) {
                $aspect->aspectRatio();
            })->save(Storage::path($dir) . $filename . '_' . $size . '.' . $extension);
        }
        return $imgs;
    }

    public static function getFilename()
    {
        return (static::$media->is_private ? 'private/' : 'public/') . static::$media->files['original'];
    }


    public static function thumb(Media $media)
    {
        return "/storage/" . $media->files['300'];
    }
}
