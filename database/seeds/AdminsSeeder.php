<?php

use Illuminate\Database\Seeder;

class AdminsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('users')->insert([
	        'firstname' => 'Strahinja',
			'middlename' => 'Sebastian',
			'lastname' => 'Banovic',
	        'email' => 'strahinja.s.banovic@gmail.com',
			'username' => 'straja',
	        'password' => bcrypt('Ika&Straja1206'),
			'type' => 0,
			'authorized' => 1
		]);
}
