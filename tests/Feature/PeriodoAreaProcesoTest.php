<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\PeriodoAreaProceso;

class PeriodoAreaProcesoTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /**
     * Test getting all periodo area proceso configurations.
     */
    public function test_can_get_all_configurations(): void
    {
        $this->actingAs($this->user, 'api');

        $response = $this->getJson('/api/periodo-area-proceso');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data'
                ]);
    }

    /**
     * Test creating a new configuration.
     */
    public function test_can_create_configuration(): void
    {
        $this->actingAs($this->user, 'api');

        $data = [
            'id_periodo' => 1,
            'id_area' => 1,
            'id_proceso' => 1,
            'id_empresa' => 1,
        ];

        $response = $this->postJson('/api/periodo-area-proceso', $data);

        // Note: This test might fail if foreign key constraints are enabled
        // and the referenced records don't exist
        $response->assertStatus(201)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'data'
                ]);
    }

    /**
     * Test validation errors.
     */
    public function test_validation_errors_on_create(): void
    {
        $this->actingAs($this->user, 'api');

        $response = $this->postJson('/api/periodo-area-proceso', []);

        $response->assertStatus(422)
                ->assertJsonStructure([
                    'success',
                    'message',
                    'errors'
                ]);
    }
}
