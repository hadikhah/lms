<?php

namespace Modules\Slider\Models;

use Modules\Media\Models\Media;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    protected $guarded = [];

    public function media()
    {
        return $this->belongsTo(Media::class, 'media_id');
    }
}
