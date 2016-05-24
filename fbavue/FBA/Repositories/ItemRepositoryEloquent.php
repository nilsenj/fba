<?php

namespace FBA\Repositories;

use FBA\Presenters\ItemPresenter;
use RepositoryLab\Repository\Eloquent\BaseRepository;
use RepositoryLab\Repository\Criteria\RequestCriteria;
use FBA\Repositories\ItemRepository;
use FBA\Models\Item;

/**
 * Class ItemRepositoryEloquent
 * @package namespace FBA\Repositories;
 */
class ItemRepositoryEloquent extends BaseRepository implements ItemRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Item::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return Item
     */
    public function getModel() {

        return new Item();
    }

//    /**
//     * @param $basketId
//     */
//    public function getItemWithBasketAttached($basketId){
//        
//        $this->
//    }

    /**
     * @return mixed
     */
//    public function presenter()
//    {
//        return ItemPresenter::class;
//    }
}
