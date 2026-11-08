<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // On initialise uniquement la table des rôles
        $this->call(RoleSeeder::class);

        $this->call([
            PndSeeder::class,
            CirconscriptionSeeder::class,
        ]);
    }
}