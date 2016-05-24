<?php

namespace App\Http\Controllers;

use FBA\Presenters\ItemPresenter;
use FBA\Repositories\ItemRepository;
use Illuminate\Http\Request;

use App\Http\Requests;

class ItemsController extends Controller
{
    /**
     * @var ItemRepository
     */
    protected $item;

    /**
     * ItemsController constructor.
     * @param ItemRepository $item
     */
    public function __construct(ItemRepository $item)
    {
        $this->item = $item;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function index()
    {
        return $this->item->setPresenter(ItemPresenter::class)->all();
    }

    /**
     * @param Request $request
     * @return static
     */
    public function store(Request $request)
    {
        if (empty($request['type']) && empty($request['weight'])) {
            return response()->json(['message' => 'Bad Request given'], 400);
        }
        $data = [
            'type' =>  $request['type'],
            'weight' => $request['weight']
        ];

        return $this->item->create($data);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id)
    {
        return $this->item->getModel()->findOrFail($id);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if (empty($request['type']) && empty($request['weight'])) {
            return response()->json(['message' => 'Bad Request given'], 400);
        }
        $data = [
            'type' =>  $request['type'],
            'weight' => $request['weight']
        ];

        $this->item->getModel()->findOrFail($id)->update($data);

        return response()->json($request->all());
    }

    /**
     * @param $basketId
     */
    public function withAttachedBasket($basketId){

        $this->item->setPresenter($basketId);

    }
    /**
     * @param $id
     * @return int
     */
    public function destroy($id)
    {
        return $this->item->delete($id);
    }
}
