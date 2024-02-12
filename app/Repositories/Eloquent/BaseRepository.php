<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contract\RepositoryInterface;

class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository implements RepositoryInterface
{

    /**
     * @inheritDoc
     */
    public function model()
    {
    }

    /**
     * runs find query if no result returns http not found error
     *
     * @param $id
     *
     * @return mixed
     */
    public function findOrFail($id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }
}
