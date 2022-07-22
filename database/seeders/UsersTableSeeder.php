<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        $rows = [

            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('admin')
            ]
        ];
        DB::table('users')->insert($rows);
    }
}
