<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PeriodoAreaProceso;
use Illuminate\Support\Facades\DB;

class PeriodoAreaProcesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        PeriodoAreaProceso::truncate();

        // Sample data - adjust IDs based on your actual data
        $configurations = [
            [
                'id_periodo' => 1,
                'id_area' => 1,
                'id_proceso' => 1,
                'id_usuario_asigno' => 1,
                'fecha_asigno' => now(),
                'id_empresa' => 1,
            ],
            [
                'id_periodo' => 1,
                'id_area' => 2,
                'id_proceso' => 1,
                'id_usuario_asigno' => 1,
                'fecha_asigno' => now(),
                'id_empresa' => 1,
            ],
            [
                'id_periodo' => 2,
                'id_area' => 1,
                'id_proceso' => 2,
                'id_usuario_asigno' => 1,
                'fecha_asigno' => now(),
                'id_empresa' => 1,
            ],
        ];

        foreach ($configurations as $config) {
            PeriodoAreaProceso::create($config);
        }

        $this->command->info('PeriodoAreaProceso seeder completed successfully!');
    }
}
