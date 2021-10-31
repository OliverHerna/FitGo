<?php

use Illuminate\Database\Seeder;

class UpdateOrderActionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->where([
            ['role_id', '=', 1],
            ['module_id', '=', 5]
        ])->update(['delete' => 1]);
        DB::table('modules')->where('id', 5)->update(['actions' => '1,1,1,1,1,0,0']);
    }
}
