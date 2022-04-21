<?php
/**
 * Makes the model that uses this trait multi tenantable
 */

namespace App\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;

trait MultiTenantable
{

    /**
     * Add the user id to the related resource while creating it
     * Add scope that will filter the data based on the current logged in user
     *
     * @return void
     */
    public static function bootMultiTenantable()
    {
        if (auth()->check()) {
            static::creating(function($model) {
                $model->user_id = auth()->id();
            });

            static::addGlobalScope('user_id', function(Builder $builder) {
                return $builder->where('user_id', auth()->id());
            });
        }
    }

}
