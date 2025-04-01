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
        // ✅ Ejecutar el seeder que creaste
        $this->call([
            UsuarioSeeder::class,
            CategoriaSeeder::class
        ]);
    }
}
