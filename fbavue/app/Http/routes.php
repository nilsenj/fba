<?php

Route::get('/', function(){

	return view('main');
});

// cors not working from middleware
header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PATCH, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');

// api routes
Route::group(['prefix' => 'api', 'middleware' => 'api'], function (\Illuminate\Routing\Router $router){

	// endpoints for item
	$router->group(['prefix' => 'item'], function (\Illuminate\Routing\Router $router) {
		$router->get('/', 'ItemsController@index');
		$router->get('/create', 'ItemsController@create');
		$router->get('/{item}', 'ItemsController@show');
		$router->get('/{item}/edit', 'ItemsController@edit');
		$router->patch('/{item}', 'ItemsController@update');
		$router->post('/', 'ItemsController@store');
		$router->delete('/{item}', 'ItemsController@destroy');
	});
	// endpoints for basket
	$router->group(['prefix' => 'basket'], function (\Illuminate\Routing\Router $router) {
		$router->get('/', 'BasketController@index');
		$router->get('/create', 'BasketController@create');
		$router->get('/{basket}', 'BasketController@show');
		$router->get('/{basket}/edit', 'BasketController@edit');
		$router->patch('/{basket}', 'BasketController@update');
		$router->post('/', 'BasketController@store');
		$router->delete('/{basket}', 'BasketController@destroy');
		
		//items for basket routes
		$router->get('/items/{id}', 'BasketController@itemsForBasket');
		$router->patch('/{basket}/items/add/{id}', 'BasketController@addItem');
		$router->delete('/{basket}/items/delete/{id}', 'BasketController@deleteItem');
	});
});

// just for fun to see what's  happening
Route::post('/api/search', function(\Illuminate\Http\Request $request){

	$query = $request->input('query');

	$items = \FBA\Models\Item::where('type', 'LIKE', "%{$query}%")->orWhere('weight', 'LIKE', "{$query}")->get()->toArray();
	$baskets = \FBA\Models\Basket::where('name', 'LIKE', "%{$query}%")->orWhere('max_capacity', 'LIKE', "{$query}")->get()->toArray();

	return response()->json([
			'data' => [$baskets, $items]
		]);
})->middleware(['Cors']);

Route::group(['middleware' => ['web']], function () {
    //
});
