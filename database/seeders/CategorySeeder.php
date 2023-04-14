<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Administração'],
            ['id' => 2, 'name' => 'Agronegócio'],
            ['id' => 3, 'name' => 'Agronomia'],
            ['id' => 4, 'name' => 'Ciências Contábeis'],
            ['id' => 5, 'name' => 'Direito'],
            ['id' => 6, 'name' => 'Estética e Cosmética'],
            ['id' => 7, 'name' => 'Gestão Comercial'],
            ['id' => 8, 'name' => 'Odontologia'],
            ['id' => 9, 'name' => 'Pedagogia'],
            ['id' => 10, 'name' => 'Produção Publicitária'],
            ['id' => 11, 'name' => 'Psicologia'],
            ['id' => 12, 'name' => 'Sistemas de Informação'],
        ]);
    }
}
