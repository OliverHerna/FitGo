<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InitTablesSeeder extends Seeder
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
                'name' => 'User',
                'resource_name' => 'usuarios',
                'actions' => '1,1,1,1,1,1,1',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Role',
                'resource_name' => 'roles',
                'actions' => '1,1,1,1,1,1,0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Paquete',
                'resource_name' => 'paquetes',
                'actions' => '1,1,1,0,0,0,0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Benefit',
                'resource_name' => 'benefits',
                'actions' => '1,1,1,0,0,0,0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'Order',
                'resource_name' => 'orders',
                'actions' => '1,1,0,0,0,0,0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'name' => 'PaqueteUser',
                'resource_name' => 'paquete_users',
                'actions' => '1,0,0,0,0,0,0',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
        ]);

        DB::table('permissions')->insert([
            [
                'role_id' => 1,
                'module_id' => 1,
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
            [
                'role_id' => 1,
                'module_id' => 2,
                'view' => 1,
                'create' => 1,
                'update' => 1,
                'delete' => 1,
                'restore' => 1,
                'force_delete' => 1,
                'log' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 1,
                'module_id' => 3,
                'view' => 1,
                'create' => 1,
                'update' => 1,
                'delete' => 0,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 1,
                'module_id' => 4,
                'view' => 1,
                'create' => 1,
                'update' => 1,
                'delete' => 0,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 1,
                'module_id' => 5,
                'view' => 1,
                'create' => 1,
                'update' => 1,
                'delete' => 0,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 1,
                'module_id' => 6,
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
            //Usuario Agente
            [
                'role_id' => 2,
                'module_id' => 1,
                'view' => 1,
                'create' => 1,
                'update' => 0,
                'delete' => 0,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 2,
                'module_id' => 2,
                'view' => 1,
                'create' => 1,
                'update' => 0,
                'delete' => 0,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 2,
                'module_id' => 3,
                'view' => 1,
                'create' => 1,
                'update' => 0,
                'delete' => 0,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 2,
                'module_id' => 4,
                'view' => 1,
                'create' => 1,
                'update' => 0,
                'delete' => 0,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 2,
                'module_id' => 5,
                'view' => 1,
                'create' => 1,
                'update' => 0,
                'delete' => 0,
                'restore' => 0,
                'force_delete' => 0,
                'log' => 0,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'role_id' => 2,
                'module_id' => 6,
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
            //Usuario Cliente
            [
                'role_id' => 3,
                'module_id' => 6,
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

        DB::table('roles')->insert([
            [
                'name' => 'Administrador',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('roles')->insert([
            [
                'name' => 'Instructor',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
        //Rol Cliente
        DB::table('roles')->insert([
            [
                'name' => 'Cliente',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

        DB::table('users')->insert([
            'role_id' => 1,
            'first_name' => 'admin',
            'last_name' => 'admin',
            'phone' => '(987) 654 1223',
            'email' => 'root@admin.com',
            'password' => bcrypt('12345678'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        // DB::table('users')->insert([
        //     'role_id' => 3,
        //     'first_name' => 'cliente',
        //     'last_name' => 'cliente',
        //     'phone' => '(789) 666 4832',
        //     'email' => 'root@client.com',
        //     'password' => bcrypt('12345678'),
        //     'company_name' => 'Compañia X',
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // DB::table('users')->insert([
        //     'role_id' => 2,
        //     'first_name' => 'agente',
        //     'last_name' => 'agente',
        //     'phone' => '(789) 666 4889',
        //     'email' => 'root@agente.com',
        //     'password' => bcrypt('12345678'),
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);

        // // DB::table('benefits')->insert([
        // //     'name' => 'Horas Extra',
        // //     'description' => 'Se aplicara un deescuento en las horas extra',
        // //     'validity' => Carbon::createFromFormat('d/m/Y', '23/02/2021')->format('Y/m/d'),
        // //     'created_at' => Carbon::now(),
        // //     'updated_at' => Carbon::now(),
        // // ]);

        // DB::table('paquetes')->insert([
        //     'name' => 'Paquete Capacitación',
        //     'total_hours' => 30,
        //     'benefit_id' => 1,
        //     'created_at' => Carbon::now(),
        //     'updated_at' => Carbon::now(),
        // ]);


        $this->call(EntitiesTableSeeder::class);
        $this->call(ClientSeeder::class);
        $this->call(LogsTableSeeder::class);
    }
}