<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'email' => 'admin@ecomp.co',
            'password' => bcrypt('secret'),
            'admin' => true,
            'company'=> '0', 
            'cnpj'=> '0', 
            'cep'=> '0', 
            'city_state'=> '0', 
            'neighborhood'=> '0', 
            'street'=> '0',
            'addressNumber'=> '0', 
            'additionalAddress'=> '0', 
            'phone'=> '0', 
            'name'=> '0', 
            'cpf'=> '0',
        ]);

        DB::table('users')->insert([
            'email' => 'mathias@ecomp.co',
            'password' => bcrypt('secret'),
            'admin' => false,
            'company'=> '0', 
            'cnpj'=> '0', 
            'cep'=> '0', 
            'city_state'=> '0', 
            'neighborhood'=> '0', 
            'street'=> '0',
            'addressNumber'=> '0', 
            'additionalAddress'=> '0', 
            'phone'=> '0', 
            'name'=> '0', 
            'cpf'=> '0',
        ]);
    }
}
