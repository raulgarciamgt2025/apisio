<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Documento;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Documento>
 */
class DocumentoFactory extends Factory
{
    protected $model = Documento::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_configuracion' => $this->faker->numberBetween(1, 10),
            'fecha_grabo' => $this->faker->dateTimeThisYear(),
            'id_usuario_grabo' => $this->faker->numberBetween(1, 5),
            'descripcion' => $this->faker->sentence(10),
            'id_usuario_editor' => $this->faker->numberBetween(1, 5),
            'id_usuario_responsable' => $this->faker->numberBetween(1, 5),
            'estado' => $this->faker->randomElement([
                Documento::ESTADO_ELABORACION,
                Documento::ESTADO_FINALIZADO,
                Documento::ESTADO_OBSOLETO
            ]),
            'id_empresa' => $this->faker->numberBetween(1, 5),
            'archivo' => $this->faker->optional(0.7)->randomElement([
                'documento_calidad.pdf',
                'manual_procedimientos.docx',
                'politica_seguridad.pdf',
                'instructivo_manejo.xlsx',
                'formato_registro.pdf'
            ]),
            'ruta' => $this->faker->optional(0.8)->randomElement([
                '/documentos/calidad/',
                '/documentos/seguridad/',
                '/documentos/procedimientos/',
                '/documentos/manuales/',
                '/documentos/formatos/'
            ]),
            'fecha_cargo_archivo' => $this->faker->optional(0.7)->dateTimeThisYear(),
            'id_usuario_cargo' => $this->faker->optional(0.7)->numberBetween(1, 5),
        ];
    }

    /**
     * Indicate that the documento is in elaboration state.
     */
    public function elaboracion(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Documento::ESTADO_ELABORACION,
        ]);
    }

    /**
     * Indicate that the documento is finalized.
     */
    public function finalizado(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Documento::ESTADO_FINALIZADO,
        ]);
    }

    /**
     * Indicate that the documento is obsolete.
     */
    public function obsoleto(): static
    {
        return $this->state(fn (array $attributes) => [
            'estado' => Documento::ESTADO_OBSOLETO,
        ]);
    }
}
