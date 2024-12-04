<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class ForeignController extends Controller
{
    public function showById($id)
    {
        $url = 'https://www.themealdb.com/api/json/v1/1/lookup.php?i=' . $id;
        return $this->fetchDataFromApi($url);
    }

    public function showByName($name)
    {
        $url = 'https://www.themealdb.com/api/json/v1/1/search.php?s=' . $name;
        return $this->fetchDataFromApi($url);
    }

    // Método general para obtener datos de la API
    private function fetchDataFromApi($url)
    {
        // Realizamos la solicitud GET a la API pública usando el cliente HTTP de Laravel
        $response = Http::get($url);

        if ($response->successful()) {
            // Decodificamos la respuesta JSON
            $data = $response->json();
            return response()->json($data);
        } else {
            return response()->json(['error' => 'No se pudo obtener datos de la API'], 500);
        }
    }

    public function show()
    {
        $id = request()->query('i');  // Capturamos el parámetro 'i' desde la URL
        $name = request()->query('s');  // Capturamos el parámetro 's' desde la URL

        // Validamos los parámetros de entrada
        if (!$id && !$name) {
            return response()->json(['error' => 'ID o nombre no proporcionados'], 400);
        }

        // Lógica para determinar qué URL usar dependiendo de los parámetros
        if ($id) {
            return $this->showById($id);  // Busca por ID
        }

        if ($name) {
            return $this->showByName($name);  // Busca por nombre
        }

        // En caso de que ocurra un error no esperado
        return response()->json(['error' => 'Error al insertar parámetros'], 400);
    }

    public function index()
    {
        // URL de la API
        $url = 'https://www.themealdb.com/api/json/v1/1/categories.php';

        // Realizamos la solicitud GET a la API pública usando el cliente HTTP de Laravel
        $response = Http::get($url);

        if ($response->successful()) {
            // Decodificamos la respuesta JSON
            $data = $response->json();
            //dd($data);


            // Verificamos si la clave 'meals' existe en los datos
            if (isset($data['categories'])) {
                // Devolvemos los datos de la API (una lista de recetas)
                return response()->json($data['categories']);
            } else {
                return response()->json(['error' => 'No se encontraron categorías'], 404);
            }
        } else {
            return response()->json(['error' => 'No se pudo obtener datos de la API'], 500);
        }
    }
}
