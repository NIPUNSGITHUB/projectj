<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $dateTime = Carbon::now()->toDateTimeString();
        DB::table('areas')->insert([
            'name' => 'Colombo',         
            'created_at' =>  $dateTime,
            'updated_at' =>  $dateTime
        ]); 

        DB::table('areas')->insert([
            'name' => 'Kandy',         
            'created_at' =>  $dateTime,
            'updated_at' =>  $dateTime
        ]); 

        DB::table('items')->insert([
            'name' => 'A4',         
            'created_at' =>  $dateTime,
            'updated_at' =>  $dateTime
        ]); 

        DB::table('items')->insert([
            'name' => 'A3',         
            'created_at' =>  $dateTime,
            'updated_at' =>  $dateTime
        ]); 

        DB::table('users')->insert([            
            'name' => 'Tempory',  
            'email' => '',  
            'password' => 'Tempory',  
            'user_type' => 'Tempory',        
            'created_at' =>  $dateTime,
            'updated_at' =>  $dateTime
        ]); 

    }
}
