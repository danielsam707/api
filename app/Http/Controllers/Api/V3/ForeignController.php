<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ForeignController extends Controller
{
    public function index()
    {
        // URL de la API
        $url = 'https://www.themealdb.com/api/json/v1/1/aleatorselection.php';

        // Realizamos la solicitud GET a la API pública usando el cliente HTTP de Laravel
        $response = Http::get($url);

        // Verificamos si la solicitud fue exitosa
        if ($response->successful()) {
            $data = $response->json();

            // Organizar y formatear la respuesta
            $formattedData = $this->formatResponse($data);

            return response()->json($formattedData);
        } else {
            // Si la solicitud falla, devolver un error
            return response()->json(['error' => 'No se pudo obtener datos de la API'], 500);
        }
    }

    // Método para formatear la respuesta
    private function formatResponse($data)
    {
        // Verificamos si existe la clave "meals" en la respuesta
        if (isset($data['meals']) && count($data['meals']) > 0) {
            $meal = $data['meals'][0]; // Suponiendo que la respuesta contiene solo una receta aleatoria

            // Extraemos y reestructuramos los datos que nos interesan
            return [
                'meal_id' => $meal['idMeal'],
                'meal_name' => $meal['strMeal'],
                'category' => $meal['strCategory'],
                'area' => $meal['strArea'],
                'instructions' => $meal['strInstructions'],
                'image' => $meal['strMealThumb'],
                'youtube' => $meal['strYoutube'],
                'ingredients' => $this->getIngredients($meal),
                'source' => $meal['strSource']
            ];
        }

        return ['message' => 'No se encontraron recetas disponibles.'];
    }

    // Método para obtener los ingredientes y sus cantidades
    private function getIngredients($meal)
    {
        $ingredients = [];

        // Recorremos los ingredientes y sus cantidades
        for ($i = 1; $i <= 20; $i++) {
            $ingredient = $meal['strIngredient' . $i];
            $measure = $meal['strMeasure' . $i];

            // Si ambos valores no están vacíos, los añadimos
            if (!empty($ingredient) && !empty($measure)) {
                $ingredients[] = [
                    'ingredient' => $ingredient,
                    'measure' => $measure
                ];
            }
        }

        return $ingredients;
    }
}
