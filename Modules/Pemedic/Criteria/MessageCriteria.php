<?php

namespace App\Pemedic\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class HomeCriteria
 * @package namespace App\Mummy\Criteria;
 */
class MessageCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $model = $model->with('doctor')->whereHas('doctor',function($query){
            $query->where('status',1);
        });
        $model->where('patient_deleted', 0);
        return $model;
    }
}
