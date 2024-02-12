<?php

namespace App\Repositories\Contract;

interface RepositoryInterface extends \Prettus\Repository\Contracts\RepositoryInterface
{
    public function findOrFail($id);
}
