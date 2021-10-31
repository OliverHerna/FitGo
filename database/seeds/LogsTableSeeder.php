<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LogsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('logs')->insert([
            ['user_id' => 1, 'entity_id' => 1, 'message' => 'Creación de rol', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['user_id' => 1, 'entity_id' => 2, 'message' => 'Creación de usuario', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['user_id' => 1, 'entity_id' => 3, 'message' => 'Creación de usuario', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['user_id' => 1, 'entity_id' => 4, 'message' => 'Creación de usuario', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['user_id' => 1, 'entity_id' => 5, 'message' => 'Creación de paquete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
            ['user_id' => 1, 'entity_id' => 6, 'message' => 'Creación de beneficio', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
        ]);
    }
}
