<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Usersorganizations.
 *
 * @package namespace App\Entities;
 */
class Usersorganizations extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "users_organizations";

    protected $fillable = ['organization_id','user_id'];

}
