<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            [
                'name' => 'Report',
                'resource_name' => 'reportes',
                'actions' => '1,1,1,1,0,0,1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        DB::table('permissions')->insert([
            [
                'role_id' => 1,
                'module_id' => 8,
                'view' => 1,
                'create' => 1,
                'update' => 1,
                'delete' => 1,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 2,
                'module_id' => 8,
                'view' => 1,
                'create' => 1,
                'update' => 1,
                'delete' => 1,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
