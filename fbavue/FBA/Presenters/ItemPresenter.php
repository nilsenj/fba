<?php

namespace FBA\Presenters;

use FBA\Transformers\ItemTransformer;
use RepositoryLab\Repository\Presenter\FractalPresenter;

/**
 * Class ItemPresenter
 *
 * @package namespace FBA\Presenters;
 */
class ItemPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ItemTransformer();
    }
}
