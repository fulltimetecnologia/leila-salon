<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'name' => 'Corte de Cabelo Feminino',
                'description' => 'Corte completo com lavagem e finalização',
                'duration_minutes' => 60,
                'price' => 80.00,
                'active' => true,
            ],
            [
                'name' => 'Corte de Cabelo Masculino',
                'description' => 'Corte completo com lavagem e finalização',
                'duration_minutes' => 45,
                'price' => 50.00,
                'active' => true,
            ],
            [
                'name' => 'Escova Progressiva',
                'description' => 'Alisamento com escova progressiva',
                'duration_minutes' => 180,
                'price' => 250.00,
                'active' => true,
            ],
            [
                'name' => 'Hidratação',
                'description' => 'Tratamento hidratante profundo',
                'duration_minutes' => 60,
                'price' => 60.00,
                'active' => true,
            ],
            [
                'name' => 'Manicure',
                'description' => 'Manicure completa',
                'duration_minutes' => 45,
                'price' => 35.00,
                'active' => true,
            ],
            [
                'name' => 'Pedicure',
                'description' => 'Pedicure completa',
                'duration_minutes' => 60,
                'price' => 40.00,
                'active' => true,
            ],
            [
                'name' => 'Design de Sobrancelha',
                'description' => 'Design e modelagem de sobrancelhas',
                'duration_minutes' => 30,
                'price' => 30.00,
                'active' => true,
            ],
            [
                'name' => 'Coloração',
                'description' => 'Coloração completa',
                'duration_minutes' => 120,
                'price' => 150.00,
                'active' => true,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
