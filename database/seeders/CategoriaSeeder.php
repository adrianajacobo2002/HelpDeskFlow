<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            'Infraestructura',
            'Aplicaciones',
            'Bases de datos',
            'Redes',
            'Correo electrónico',
            'Soporte técnico',
            'Hardware',
            'Seguridad informática',
            'Otros'
        ];

        foreach ($categorias as $nombre) {
            Categoria::create(['nombre' => $nombre]);
        }
    }
}
