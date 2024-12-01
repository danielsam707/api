<?php

namespace Tests\Feature\Http\Controllers\Api\V2;

use App\Models\Category;
use App\Models\Recipe;
use App\Models\User;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;



class RecipeTest extends TestCase
{
    use RefreshDatabase;// Trabajamos con la base de datos
    public function test_index_v2(): void
    {
        Sanctum::actingAs(User::factory()->create());

        Category::factory()->create();
        $recipe = Recipe::factory(5)->create();

        $response = $this->get('/api/v2/recipes');

        $response->assertJsonCount(5, 'data')
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'data' => [],
                'links' => [],
                'meta' => []
            ]);
    }



}
