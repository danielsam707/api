<?php

namespace  Tests\Feature\Http\Controllers\Api\V1;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

// para trabajar con las respuestas
// se importan los modelos que se  van a usar
// este es porque se necesita un usuario para iniciar sesion
// Esta es la tecnologia que utilizamos para iniciar sesion


class TagTest extends TestCase
{
    use RefreshDatabase;// Trabajamos con la base de datos
    public function test_index(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $tag = Tag::factory(2)->create();
        $response = $this->get('/api/v1/tags');

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

        $response = $this->get('/api/v1/tags/' . $tag->id);
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
