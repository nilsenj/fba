<?php

namespace FBA\Repositories;

use FBA\Presenters\BasketPresenter;
use RepositoryLab\Repository\Eloquent\BaseRepository;
use RepositoryLab\Repository\Criteria\RequestCriteria;
use FBA\Repositories\BasketRepository;
use FBA\Models\Basket;
/**
 * Class BasketRepositoryEloquent
 * @package namespace FBA\Repositories;
 */
class BasketRepositoryEloquent extends BaseRepository implements BasketRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Basket::class;
    }

    protected $skipPresenter = false;

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    public function getModel() {
        
        return new Basket();
    }

//    public function presenter()
//    {
//        return BasketPresenter::class;
//    }

}
