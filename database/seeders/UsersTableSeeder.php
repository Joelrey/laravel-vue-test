<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'username' => 'admin',
                'email' => 'admin@mail.com',
                'phone' => '+639876543210',
                'email_verified_at' => NULL,
                'password' => bcrypt('vIzqCQG9OJC835'),
                'is_admin' => 1,
                'remember_token' => NULL,
                'created_at' => '2023-06-17 03:03:34',
                'updated_at' => '2023-06-17 03:03:34',
            ),
            1 => 
            array (
                'username' => 'test',
                'email' => 'test@mail.com',
                'phone' => '+639876543210',
                'email_verified_at' => NULL,
                'password' => bcrypt('vIzqCQG9OJC835'),
                'is_admin' => 0,
                'remember_token' => NULL,
                'created_at' => '2023-06-17 03:12:18',
                'updated_at' => '2023-06-17 03:12:18',
            ),
        ));        
    }
}