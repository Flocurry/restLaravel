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
                'role_id' => 1
            ],
            [
                'username' => 'Sandra',
                'password' => Hash::make('sCfD20042011'),
                'firstname' => 'Sandra',
                'lastname' => 'CANDAU',
                'email' => 'test@msn.com',
                'sexe' => 'Femme',
                'role_id' => 2
            ]
        ]);
    }
}
