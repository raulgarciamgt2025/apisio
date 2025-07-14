<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Documento;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing data
        Documento::truncate();

        // Sample data - adjust IDs based on your actual data
        $documentos = [
            [
                'id_configuracion' => 1,
                'fecha_grabo' => now(),
                'id_usuario_grabo' => 1,
                'descripcion' => 'Manual de Procedimientos de Calidad',
                'id_usuario_editor' => 1,
                'id_usuario_responsable' => 1,
                'estado' => Documento::ESTADO_ELABORACION,
                'id_empresa' => 1,
                'archivo' => 'manual_procedimientos_calidad.pdf',
                'ruta' => '/documentos/calidad/',
                'fecha_cargo_archivo' => now(),
                'id_usuario_cargo' => 1,
            ],
            [
                'id_configuracion' => 1,
                'fecha_grabo' => now(),
                'id_usuario_grabo' => 1,
                'descripcion' => 'Política de Seguridad y Salud Ocupacional',
                'id_usuario_editor' => 1,
                'id_usuario_responsable' => 1,
                'estado' => Documento::ESTADO_FINALIZADO,
                'id_empresa' => 1,
                'archivo' => 'politica_seguridad_salud.docx',
                'ruta' => '/documentos/seguridad/',
                'fecha_cargo_archivo' => now(),
                'id_usuario_cargo' => 1,
            ],
            [
                'id_configuracion' => 2,
                'fecha_grabo' => now(),
                'id_usuario_grabo' => 1,
                'descripcion' => 'Instructivo de Manejo de Residuos',
                'id_usuario_editor' => 1,
                'id_usuario_responsable' => 1,
                'estado' => Documento::ESTADO_ELABORACION,
                'id_empresa' => 1,
                'archivo' => null, // No file attached yet
                'ruta' => '/documentos/procedimientos/',
                'fecha_cargo_archivo' => null,
                'id_usuario_cargo' => null,
            ],
        ];

        foreach ($documentos as $documento) {
            Documento::create($documento);
        }

        // Create additional random documents using factory
        Documento::factory()->count(10)->create();

        $this->command->info('Documento seeder completed successfully!');
    }
}
