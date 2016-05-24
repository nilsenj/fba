<?php
/**
 * Created by PhpStorm.
 * User: nilse
 * Date: 5/18/2016
 * Time: 11:53 PM
 */

namespace FBA\Presenters;


use FBA\Transformers\BasketsForItemTransformer;
use RepositoryLab\Repository\Presenter\FractalPresenter;

class BasketsForItemPresenter extends FractalPresenter
{

    public function getTransformer()
    {
        // TODO: Implement getTransformer() method.
        return new BasketsForItemTransformer();
    }

}