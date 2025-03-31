<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        User::create([
            'nombre' => 'Admin',
            'apellido' => 'Principal',
            'email' => 'admin@helpdeskflow.com',
            'password' => Hash::make('password'),
            'rol' => 'admin',
        ]);

        // Agentes
        $agentes = [
            ['nombre' => 'Carlos', 'apellido' => 'Pérez', 'email' => 'carlos@helpdeskflow.com'],
            ['nombre' => 'Laura', 'apellido' => 'Gómez', 'email' => 'laura@helpdeskflow.com'],
            ['nombre' => 'Andrés', 'apellido' => 'Ramírez', 'email' => 'andres@helpdeskflow.com'],
        ];

        foreach ($agentes as $agente) {
            User::create([
                'nombre' => $agente['nombre'],
                'apellido' => $agente['apellido'],
                'email' => $agente['email'],
                'password' => Hash::make('password'),
                'rol' => 'agente',
            ]);
        }
    }
}

