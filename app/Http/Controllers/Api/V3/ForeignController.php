<?php

namespace App\Http\Controllers\Api\V3;

use App\Http\Controllers\Controller;
use http\Env\Response;
use Illuminate\Support\Facades\Http;

class ForeignController extends Controller
{
    //------------------------------------------------------------------------------
    // MOSTRAR RECURSOS INDIVIDUALES (RECETAS)
    public function show()
    {
        $id = request()->query('i');  // Capturamos el parámetro 'i' desde la URL
        $name = request()->query('s');  // Capturamos el parámetro 's' desde la URL

        // Validamos los parámetros de entrada
        if (!$id && !$name) {
            return $this->showRandom();
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

    public function showRandom()
    {
        $url = 'https://www.themealdb.com/api/json/v1/1/random.php';
        return $this->fetchDataFromApi($url);
    }


    //------------------------------------------------------------------------
    // MOSTRAR LISTA DE RECURSOS DE MODO DINAMICO (LISTA DE RECETAS)

    public function showListDynamic()
    {
        $categories = request()->query('c');
        $letter = request()->query('f');
        $area = request()->query('a');

//        dd(request()->query());
        // Validamos los parámetros de entrada
        // Lógica para determinar qué URL usar dependiendo de los parámetros
        if ($categories) {
            return $this->showByCategories($categories);  // Busca por ID
        }

        if ($letter) {
            return $this->showByLetters($letter);  // Busca por nombre
        }

        if ($area) {
            return $this->showByArea($area);  // Busca por nombre
        }
        if (!$categories && !$letter && !$area) {
            return response()->json(['error => Error al insertar parametros'], 400);
        }

        // En caso de que ocurra un error no esperado
        return response()->json(['error' => 'Error  con algo'], 400);
    }

    private function fetchColletionFromApi($url)
    {
        // Realizamos la solicitud GET a la API pública usando el cliente HTTP de Laravel
        $response = Http::get($url);

        if ($response->successful()) {
            // Decodificamos la respuesta JSON
            $data = $response->json();


            // Verificamos si la clave 'meals' existe en los datos
            if (isset($data['meals'])) {
                // Devolvemos los datos de la API (una lista de recetas)
                return response()->json($data['meals']);
            } else {
                return response()->json(['error' => 'No se encontraron categorías'], 404);
            }
        } else {
            return response()->json(['error' => 'No se pudo obtener datos de la API'], 500);
        }
    }

    public function ShowByCategories($categories)
    {
        $url = 'https://www.themealdb.com/api/json/v1/1/filter.php?c='.$categories;
        return $this->fetchColletionFromApi($url);
    }

    public function ShowByLetters($letter)
    {
        $url = 'https://www.themealdb.com/api/json/v1/1/search.php?f='.$letter;
        return $this->fetchColletionFromApi($url);
    }

    public function ShowByArea($area)
    {
        $url = 'https://www.themealdb.com/api/json/v1/1/filter.php?a='.$area;
        return $this->fetchColletionFromApi($url);
    }
    //------------------------------------------------------------------------
    // MOSTRAR LISTA DE RECURSOS DE MODO ESTATICO (LISTA DE RECETAS)

    public function showCategories()
    {
        $url = 'https://www.themealdb.com/api/json/v1/1/list.php?c=list';

        $response = Http::get($url);

        if ($response->successful()) {
            // Decodificamos la respuesta JSON
            $data = $response->json();


            // Verificamos si la clave 'meals' existe en los datos
            if (isset($data['meals'])) {
                // Devolvemos los datos de la API (una lista de recetas)
                return response()->json($data['meals']);
            } else {
                return response()->json(['error' => 'No se encontraron categorías'], 404);
            }
        } else {
            return response()->json(['error' => 'No se pudo obtener datos de la API'], 500);
        }



    }

    public function showAreas()
    {
        $url = 'www.themealdb.com/api/json/v1/1/list.php?a=list';

        $response = Http::get($url);

        if ($response->successful()) {
            // Decodificamos la respuesta JSON
            $data = $response->json();


            // Verificamos si la clave 'meals' existe en los datos
            if (isset($data['meals'])) {
                // Devolvemos los datos de la API (una lista de recetas)
                return response()->json($data['meals']);
            } else {
                return response()->json(['error' => 'No se encontraron categorías'], 404);
            }
        } else {
            return response()->json(['error' => 'No se pudo obtener datos de la API'], 500);
        }
    }

    public function showIngredients()
    {
        $url = 'www.themealdb.com/api/json/v1/1/list.php?i=list';

        $response = Http::get($url);

        if ($response->successful()) {
            // Decodificamos la respuesta JSON
            $data = $response->json();


            // Verificamos si la clave 'meals' existe en los datos
            if (isset($data['meals'])) {
                // Devolvemos los datos de la API (una lista de recetas)
                return response()->json($data['meals']);
            } else {
                return response()->json(['error' => 'No se encontraron categorías'], 404);
            }
        } else {
            return response()->json(['error' => 'No se pudo obtener datos de la API'], 500);
        }
    }
}
