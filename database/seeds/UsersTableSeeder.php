<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([[
                'username' => 'Florian',
                'password' => Hash::make('Scottie33$'),
                'firstname' => 'Florian',
                'lastname' => 'DARRIGAND',
                'email' => 'flodarrigand@msn.com',
                'sexe' => 'Homme',
                'image' => 'florian.png', 
                'role_id' => 1,
                'is_connected' => false
            ],
            [
                'username' => 'Sandra',
                'password' => Hash::make('sCfD20042011'),
                'firstname' => 'Sandra',
                'lastname' => 'CANDAU',
                'email' => 'test@msn.com',
                'sexe' => 'Femme',
                'image' => 'sandra.png',
                'role_id' => 2,
                'is_connected' => false
            ]
        ]);
    }
}
