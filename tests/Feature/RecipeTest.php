<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use Symfony\Component\HttpFoundation\Response; // para trabajar con las respuestas
use App\Models\Recipe; // se importan los modelos que se  van a usar
use App\Models\Category; // porque una recesa requiera de una categoria y como se cran datos de prueba por eso se necesita
use App\Models\User; // este es porque se necesita un usuario para iniciar sesion
use Laravel\Sanctum\Sanctum; // Esta es la tecnologia que utilizamos para iniciar sesion


class RecipeTest extends TestCase
{
    use RefreshDatabase;// Trabajamos con la base de datos
    public function test_index(): void
    {
        Sanctum::actingAs(User::factory()->create());

        Category::factory()->create();
        $recipe = Recipe::factory(2)->create();

        $response = $this->get('/api/recipes');

        $response->assertJsonCount(2, 'data')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [
                    [
                        'id',
                        'type',
                        'attributes' => ['title', 'description'], //poner el resto de campos
                    ]
                ]
            ]);
    }

    public function test_show(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $recipes = Recipe::factory()->create();

        $response = $this->get('/api/recipes/' . $recipes->id);
        $response->assertStatus(Response::HTTP_OK)//200
        ->assertJsonStructure([
            'data' => [
                'id',
                'type',
                'attributes' =>  ['title', 'description'], //poner el resto de campos

            ]
        ]);
    }

    public function test_delete(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory()->create();

        $recipes = Recipe::factory()->create();

        $response = $this->deleteJson('/api/recipes/' . $recipes->id);
        $response->assertStatus(Response::HTTP_NO_CONTENT);

    }

}
