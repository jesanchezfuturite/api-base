<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProfilestoolsRepository;
use App\Entities\Profilestools;
use App\Validators\ProfilestoolsValidator;

/**
 * Class ProfilestoolsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProfilestoolsRepositoryEloquent extends BaseRepository implements ProfilestoolsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Profilestools::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
