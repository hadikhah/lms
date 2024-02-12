<?php

namespace Modules\Category\Repositories;

use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Modules\Category\Models\Category;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Category::class;
    }


    /**
     * Boot up the repository, pushing criteria
     * @throws RepositoryException
     */
    public function boot(): void
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * getting all except fields with given id
     *
     * @param int $id
     *
     * @return LengthAwarePaginator|Collection|mixed
     */
    public function allExceptById(int $id): mixed
    {
        return $this->all()->filter(function ($item) use ($id) {
            return $item->id != $id;
        });
    }

    /**
     *  retrieves all the categories
     *
     * @return \Illuminate\Database\Eloquent\Collection|array
     */
    public function tree(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->model->query()->where('parent_id', null)->with('subCategories')->get();
    }
}
