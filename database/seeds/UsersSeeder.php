<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Gilberto Villani Brito',
            'login' => 'gilberto',
            'password' => bcrypt('123'),
            'departamento_id' => 1,
        ]);
    }
}
