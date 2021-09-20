<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

/**
 * Class Profilestools.
 *
 * @package namespace App\Entities;
 */
class Profilestools extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = "profiles_tools";
    protected $fillable = ['profiles_id','tools_id','organization_id'];

}
