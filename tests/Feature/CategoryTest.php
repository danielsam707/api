<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Symfony\Component\HttpFoundation\Response; // para trabajar con las respuestas
use App\Models\Category; // se importan los modelos que se  van a usar
use App\Models\User; // este es porque se necesita un usuario para iniciar sesion
use Laravel\Sanctum\Sanctum; // Esta es la tecnologia que utilizamos para iniciar sesion


class CategoryTest extends TestCase
{
    use RefreshDatabase;// Trabajamos con la base de datos
    public function test_index(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory(2)->create();
        $response = $this->get('/api/categories');

        $response->assertJsonCount(2, 'data')
                 ->assertJsonStructure([
                     'data' => [
                         [
                             'id',
                             'type',
                             'attributes' => ['name'],
                         ]
                     ]
        ]);
    }

    public function test_show(): void
    {
        Sanctum::actingAs(User::factory()->create());
        $category = Category::factory()->create();
        $response = $this->get('/api/categories/' . $category->id);
        $response->assertStatus(Response::HTTP_OK)//200
                 ->assertJsonStructure([
                     'data' => [
                         'id',
                         'type',
                         'attributes' => ['name'],
                     ]
                ]);
    }

}
