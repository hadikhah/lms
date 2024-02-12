<?php

namespace Modules\Category\Repositories;


use App\Repositories\Contract\RepositoryInterface;

/**
 * Interface CategoryRepository.
 *
 * @package namespace App\Repositories\\Modules\Category\Models;
 */
interface CategoryRepositoryInterface extends RepositoryInterface
{
    public function tree();

    public function allExceptById(int $id);
}
