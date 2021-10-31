<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('entities')->insert([
            ['entitiabble_id' => 1, 'entitiabble_type' => 'App\Role', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['entitiabble_id' => 1, 'entitiabble_type' => 'App\User', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['entitiabble_id' => 1, 'entitiabble_type' => 'App\Paquete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['entitiabble_id' => 1, 'entitiabble_type' => 'App\Benefit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['entitiabble_id' => 1, 'entitiabble_type' => 'App\Order', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
