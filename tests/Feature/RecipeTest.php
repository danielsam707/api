<?php

namespace Tests\Feature;

//use GuzzleHttp\Psr7\UploadedFile;
use Illuminate\Http\UploadedFile;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;//para usar los fakers


use Tests\TestCase;

use Symfony\Component\HttpFoundation\Response; // para trabajar con las respuestas
use App\Models\Recipe; // se importan los modelos que se  van a usar
use App\Models\Category; // porque una recesa requiera de una categoria y como se cran datos de prueba por eso se necesita
use App\Models\User; // este es porque se necesita un usuario para iniciar sesion
use App\Models\Tag;
use Laravel\Sanctum\Sanctum; // Esta es la tecnologia que utilizamos para iniciar sesion


class RecipeTest extends TestCase
{
    use RefreshDatabase, WithFaker;// Trabajamos con la base de datos
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

    public function test_store(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory()->create();
        $tag = Tag::factory()->create();

        $data = [
            'category_id' => $category->id,
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'ingredients' => $this->faker->text,
            'instructions' => $this->faker->text,
            'tags' => $tag->id,
            'image' => UploadedFile::fake()->image('image.jpg'),
        ];

        $response = $this->postJson('/api/recipes/' , $data);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_update(): void
    {
        Sanctum::actingAs(User::factory()->create());

        $category = Category::factory()->create();
        $recipes = Recipe::factory()->create();

        $data = [
            'category_id' => $category->id,
            'title' => 'updated title',
            'description' => 'updated description',
            'ingredients' => $this->faker->text,
            'instructions' => $this->faker->text,
        ];

        $response = $this->putJson('/api/recipes/' .$recipes->id , $data);
        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('recipes' , [
            'title' => 'updated title',
            'description' => 'updated description',
        ]);

    }

}
