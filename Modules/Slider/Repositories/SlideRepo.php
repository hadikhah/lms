<?php

namespace Modules\Slider\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Slider\Models\Slide;

class SlideRepo
{
    public function all(): Collection|array
    {
        return Slide::query()->orderBy("priority")->get();
    }


    public function findById($id): Model|Collection|Builder|array|null
    {
        return Slide::query()->findOrFail($id);
    }

    public function store($values): Model|Builder
    {
        return Slide::query()->create([
            "user_id" => auth()->id(),
            'priority' => $values->priority,
            'media_id' => $values->media_id,
            'link' => $values->link,
            'status' => $values->status,
        ]);
    }

    public function update($id, $values): void
    {
        Slide::query()->where('id', $id)->update([
            'priority' => $values->priority,
            'media_id' => $values->media_id,
            'link' => $values->link,
            'status' => $values->status,
        ]);
    }

    public function delete($id): void
    {
        Slide::query()->where('id', $id)->delete();
    }
}
