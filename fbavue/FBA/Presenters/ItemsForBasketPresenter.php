<?php
/**
 * Created by PhpStorm.
 * User: nilse
 * Date: 5/18/2016
 * Time: 11:55 PM
 */

namespace FBA\Presenters;

use FBA\Transformers\ItemsForBasketTransformer;
use RepositoryLab\Repository\Presenter\FractalPresenter;

/**
 * Class ItemsForBasketPresenter
 * @package FBA\Presenters
 */
class ItemsForBasketPresenter extends FractalPresenter
{

    /**
     * @return ItemsForBasketTransformer
     */
    public function getTransformer()
    {
        return new ItemsForBasketTransformer();

    }

}