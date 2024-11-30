<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Symfony\Component\HttpFoundation\Response; // para trabajar con las respuestas
use App\Models\Tag; // se importan los modelos que se  van a usar
use App\Models\User; // este es porque se necesita un usuario para iniciar sesion
use Laravel\Sanctum\Sanctum; // Esta es la tecnologia que utilizamos para iniciar sesion


class TagTest extends TestCase
{
    use RefreshDatabase;// Trabajamos con la base de datos
    public function test_index(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $tag = Tag::factory(2)->create();
        $response = $this->get('/api/tags');

        $response->assertJsonCount(2, 'data')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'type',
                        'attributes' => ['name'],
                        'relationships' => [
                            'recipes' => []
                        ]
                    ]
                ]
            ]);
    }

    public function test_show(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $tag = Tag::factory()->create();

        $response = $this->get('/api/tags/' . $tag->id);
        $response->assertStatus(Response::HTTP_OK)//200
        ->assertJsonStructure([
            'data' => [
                'id',
                'type',
                'attributes' => ['name'],
                'relationships' => [
                    'recipes' => []
                ]
            ]
        ]);
    }

}
