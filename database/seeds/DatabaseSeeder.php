<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('areas')->insert([
            'name' => 'Colombo',         
            'created_at' =>  '2019-12-31 11:49:29', 
            'updated_at' =>  '2020-01-02 10:37:36'
        ]); 

        DB::table('areas')->insert([
            'name' => 'Kandy',         
            'created_at' =>  '2019-12-31 11:49:29', 
            'updated_at' =>  '2020-01-02 10:37:36'
        ]); 

        DB::table('items')->insert([
            'name' => 'A4',         
            'created_at' =>  '2019-12-31 11:49:29', 
            'updated_at' =>  '2020-01-02 10:37:36'
        ]); 

        DB::table('items')->insert([
            'name' => 'A3',         
            'created_at' =>  '2019-12-31 11:49:29', 
            'updated_at' =>  '2020-01-02 10:37:36'
        ]); 

    }
}
