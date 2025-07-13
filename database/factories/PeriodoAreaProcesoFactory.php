<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\PeriodoAreaProceso;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PeriodoAreaProceso>
 */
class PeriodoAreaProcesoFactory extends Factory
{
    protected $model = PeriodoAreaProceso::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_periodo' => $this->faker->numberBetween(1, 10),
            'id_area' => $this->faker->numberBetween(1, 10),
            'id_proceso' => $this->faker->numberBetween(1, 10),
            'id_usuario_asigno' => $this->faker->numberBetween(1, 5),
            'fecha_asigno' => $this->faker->dateTime(),
            'id_empresa' => $this->faker->numberBetween(1, 5),
        ];
    }
}
