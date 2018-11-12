<?php
 
class UserTableSeeder extends Seeder {
 
    public function run()
    {
        DB::table('users')->delete();
 
        User::create(array(
            'name' => 'firstuser',
            'password' => Hash::make('first_password')
        ));
 
        User::create(array(
            'name' => 'seconduser',
            'password' => Hash::make('second_password')
        ));
    }
 
}
