<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categorias = [
            [
                'nome' => 'Manutenção'
            ],
            [
                'nome' => 'Suporte RH'
            ],
            [
                'nome' => 'TI'
            ]
        ];

        foreach ($categorias as $categoria) {
            Categoria::firstOrCreate(
                ['nome' => $categoria['nome']],
                $categoria
            );
        }
    }
}
