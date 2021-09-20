<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ProfilesRepository;
use App\Entities\Profiles;
use App\Validators\ProfilesValidator;

/**
 * Class ProfilesRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ProfilesRepositoryEloquent extends BaseRepository implements ProfilesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Profiles::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
