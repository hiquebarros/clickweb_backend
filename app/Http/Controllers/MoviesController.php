<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    public function index(Request $request)
    {
        // Pega o número da página da query string (padrão: 1)
        $page = $request->input('page', 1);
        
        // Faz a requisição para a API com o parâmetro de página
        /** @var \Illuminate\Http\Client\Response $apiResponse */
        $apiResponse = Http::withHeaders([
            'x-rapidapi-host' => 'moviesdatabase.p.rapidapi.com',
            'x-rapidapi-key' => 'eb7d2c7e86mshf7ebce062fd8f29p1c6a27jsn9679c95cfdef',
        ])->get('https://moviesdatabase.p.rapidapi.com/titles', [
            'page' => $page,
        ]);

        $response = $apiResponse->json();
        
        // Informações de paginação
        $currentPage = $page;
        $hasNextPage = isset($response['page']) && isset($response['entries']) && count($response['results'] ?? []) > 0;
        
        return view('movies.index', compact('response', 'currentPage', 'hasNextPage'));
    }

}
