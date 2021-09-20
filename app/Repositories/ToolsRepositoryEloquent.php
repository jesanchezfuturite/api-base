<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\ToolsRepository;
use App\Entities\Tools;
use App\Validators\ToolsValidator;

/**
 * Class ToolsRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class ToolsRepositoryEloquent extends BaseRepository implements ToolsRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Tools::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
}
