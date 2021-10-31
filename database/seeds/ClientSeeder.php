<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientSeeder extends Seeder
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
                'name' => 'Client',
                'resource_name' => 'clients',
                'actions' => '1,1,1,1,1,1,1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);
        DB::table('permissions')->insert([
            //Usuario Administrador
            [
                'role_id' => 1,
                'module_id' => 7,
                'view' => 1,
                'create' => 1,
                'update' => 1,
                'delete' => 1,
                'restore' => 1,
                'force_delete' => 1,
                'log' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            //Usuario Agente
            [
                'role_id' => 2,
                'module_id' => 7,
                'view' => 1,
                'create' => 0,
                'update' => 0,
                'delete' => 0,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
