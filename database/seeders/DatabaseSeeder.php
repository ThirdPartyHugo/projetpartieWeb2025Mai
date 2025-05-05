<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ProduitSeeder::class, RoleSeeder::class, UserSeeder::class, StatutSeeder::class, CommandeSeeder::class
        ]);
    }
}
