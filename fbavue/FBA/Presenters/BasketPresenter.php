<?php

namespace FBA\Presenters;

use FBA\Transformers\BasketTransformer;
use RepositoryLab\Repository\Presenter\FractalPresenter;

/**
 * Class BasketPresenter
 *
 * @package namespace FBA\Presenters;
 */
class BasketPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new BasketTransformer();
    }
}
