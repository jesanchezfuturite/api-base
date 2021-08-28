<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\UserstoolsRepository;
use App\Entities\Userstools;
use App\Validators\UserstoolsValidator;

/**
 * Class UserstoolsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class UserstoolsRepositoryEloquent extends BaseRepository implements UserstoolsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Userstools::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
