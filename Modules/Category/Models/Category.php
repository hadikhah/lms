<?php

namespace Modules\Category\Models;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Translation\Translator;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Course\Models\Course;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $guarded = [];

    /**
     * returns parent category title
     *
     * @return array|Application|Translator|\Illuminate\Foundation\Application|string|null
     */
    public function getParentAttribute(): \Illuminate\Foundation\Application|array|string|Translator|Application|null
    {
        return (is_null($this->parent_id)) ? __("none") : $this->parentCategory->title;
    }

    /**
     * parent category relation
     *
     * @return BelongsTo
     */
    public function parentCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * sub category relation
     *
     * @return HasMany
     */
    public function subCategories(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * courses relation
     * each category has many courses
     *
     * @return HasMany
     */
    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function path()
    {
        return route('categories.show', $this->id);
    }
}
