<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Type;

class TypeSeeder extends Seeder
{
        public function run()
    {
        $types = ['Perro', 'Gato', 'Pajaro', 'Conejo', 'Pez'];

        foreach ($types as $type) {
            Type::create(['name' => $type, 'description' => 'Tipo de animal: ' . $type]);
        }
    }
}

