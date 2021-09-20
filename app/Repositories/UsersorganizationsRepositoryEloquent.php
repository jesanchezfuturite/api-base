<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UsersorganizationsRepository;
use App\Entities\Usersorganizations;
use App\Validators\UsersorganizationsValidator;

/**
 * Class UsersorganizationsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UsersorganizationsRepositoryEloquent extends BaseRepository implements UsersorganizationsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Usersorganizations::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
