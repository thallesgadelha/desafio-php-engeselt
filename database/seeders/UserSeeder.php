<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $usuarios = [
            [
                'name' => 'Colaborador',
                'email' => 'colaborador@mail.com',
                'password' => bcrypt('colaborador#engeselt'),
                'role' => 'colaborador',
            ],
            [
                'name' => 'Técnico',
                'email' => 'tecnico@mail.com',
                'password' => bcrypt('tecnico#engeselt'),
                'role' => 'tecnico',
            ],
        ];

        foreach ($usuarios as $usuario) {
            User::firstOrCreate(
                ['email' => $usuario['email']],
                $usuario                        
            );
        }
    }
}
