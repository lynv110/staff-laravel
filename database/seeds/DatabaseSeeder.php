<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default root account
        DB::table('staff')->insert([
            'name' => 'Staff Admin',
            'telephone' => '0986087298',
            'gender' => '0',
            'email' => 'admin@admin.admin',
            'username' => 'admin',
            'password' => \Illuminate\Support\Facades\Hash::make('123456'),
            'status' => 1,
            'changed_password' => 0,
            'is_root' => 1,
        ]);
    }
}
