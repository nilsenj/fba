<?php

use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \FBA\Models\Item::create([
            'type' => 'apple',
            'weight'	=> 345
        ]);
        \FBA\Models\Item::create([
            'type' => 'orange',
            'weight' => 25
        ]);
        \FBA\Models\Item::create([
            'type' => 'watermelon',
            'weight' => 12
        ]);
    }
}
