<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        $seeders = [
            RolesTableSeeder::class, UsersTableSeeder::class,
        ];
        foreach ($seeders as $seeder) {
            $this->call($seeder);
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        Model::reguard();
    }
}
