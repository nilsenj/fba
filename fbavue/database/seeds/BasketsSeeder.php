<?php

use Illuminate\Database\Seeder;

class BasketsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \FBA\Models\Basket::create([
            'name' => 'test 1',
            'contents' => json_encode([['item_id' => 1, 'weight' =>  345], ['item_id' => 3, 'weight' => 12]]),
            'max_capacity'	=> 357
        ]);
        \FBA\Models\Basket::create([
            'name' => 'test 2',
            'contents' =>  json_encode([['item_id' => 2, 'weight' =>  25], ['item_id' => 3, 'weight' => 12]]),
            'max_capacity'  => 55
        ]);
        \FBA\Models\Basket::create([
            'name' => 'test 3',
            'contents' => json_encode([['item_id' => 1, 'weight' =>  345], ['item_id' => 2, 'weight' => 25]]),
            'max_capacity'  => 58890.432
        ]);
        \FBA\Models\Basket::create([
            'name' => 'test 4',
            'contents' => json_encode([['item_id' => 3, 'weight' => 12]]),
            'max_capacity'  => 34.5
        ]);
    }
}
