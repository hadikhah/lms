<?php
namespace Modules\Media\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Media\Models\Media;
use Modules\Media\Services\MediaFileService;
use Illuminate\Http\Request;

class MediaController extends Controller{
    public function download(Media $media, Request $request)
    {
        if (!$request->hasValidSignature()) {
            abort(401);
        }

        return MediaFileService::stream($media);
    }
}
