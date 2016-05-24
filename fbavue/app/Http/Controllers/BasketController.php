<?php

namespace App\Http\Controllers;

use FBA\Presenters\BasketPresenter;
use FBA\Presenters\ItemsForBasketPresenter;
use FBA\Repositories\BasketRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

use App\Http\Requests;

/**
 * Class BasketController
 * @package App\Http\Controllers
 */
class BasketController extends Controller
{
    /**
     * @var BasketRepository
     */
    protected $basket;

    /**
     * BasketController constructor.
     * @param BasketRepository $basket
     */
    public function __construct(BasketRepository $basket)
    {
        $this->basket = $basket;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return $this->basket->setPresenter(BasketPresenter::class)->paginate(2);
    }

    /**
     * store basket endpoint
     * @param Requests\StoreBasketRequest $request
     * @return mixed
     */
    public function store(Requests\StoreBasketRequest $request)
    {
        $data = [
           'name' =>  $request['name'],
           'max_capacity' => $request['max_capacity'],
           'contents' => json_encode([])
        ];
        return $this->basket->create($data);
    }

    /**
     * show single basket
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->basket->getModel()->findOrFail($id);
    }

    /**
     * get items for basket endpoint
     * @param $id
     * @return mixed
     */
    public function itemsForBasket($id) {

        try {

            $baskets = $this->basket->setPresenter(ItemsForBasketPresenter::class);
            return $baskets->find(intval($id));

        } catch (ModelNotFoundException $e) {

            return response()->json(['responseJSON' => $e->getMessage(), 'code' => $e->getCode()], $e->getCode());
        } catch (\Exception $e) {

            return response()->json(['responseJSON' => 'Error appeared. Please connect to admin.', 'code' => $e->getCode(), $e->getCode()], $e->getCode());
        }
    }

    /**
     * add item to basket endpoint
     *
     * @param $basket id
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function addItem($basket, $id) {
        try {
            return $this->basket->getModel()->findOrFail($basket)->addItem($id);
        }
        catch (ModelNotFoundException $e) {

            return response()->json(['responseJSON' => $e->getMessage(), 'code' => $e->getCode()], $e->getCode());
        }
        catch (\Exception $e) {

            return response()->json(['responseJSON' => $e->getMessage(), 'code' => $e->getCode()], $e->getCode());
        }
    }

    /**
     * delete item from basket endpoint
     *
     * @param $basket
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteItem($basket, $id) {
        try {
            return $this->basket->getModel()->findOrFail($basket)->deleteItem($id);
        }
        catch (ModelNotFoundException $e) {

            return response()->json(['responseJSON' => $e->getMessage(), 'code' => $e->getCode()], $e->getCode());
        }
        catch (\Exception $e) {

            return response()->json(['responseJSON' => $e->getMessage(), 'code' => $e->getCode()], $e->getCode());
        }
    }

    /**
     * update the basket name and max_capacity
     *
     * @param Requests\UpdateBasketRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Requests\UpdateBasketRequest $request, $id)
    {
        $data = [
            'name' =>  $request['name'],
            'max_capacity' => $request['max_capacity']
        ];

        $this->basket->getModel()->findOrFail($id)->update($data);

        return response()->json($request->all());

    }

    /**
     * delete the basket
     * @param $basket
     * @return int
     */
    public function destroy($basket)
    {
        try {
            return $this->basket->getModel()->destroy($basket);
        }
        catch (ModelNotFoundException $e) {

            return response()->json(['responseJSON' => $e->getMessage(), 'code' => $e->getCode()], $e->getCode());
        }
        catch (\Exception $e) {

            return response()->json(['responseJSON' => 'Basket Not deleted', 'code' => 500], 500);
        }
    }
}
