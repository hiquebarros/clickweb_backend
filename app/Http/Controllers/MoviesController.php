<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    public function index(Request $request)
    {
        // Valida o parâmetro de página
        $validated = $request->validate([
            'page' => 'nullable|integer|min:1|max:1000',
        ]);
        
        // Pega o número da página da query string (padrão: 1)
        $page = $validated['page'] ?? 1;
        
        // Configurações da API
        $apiHost = config('services.rapidapi.movies.host');
        $apiKey = config('services.rapidapi.movies.key');
        $apiUrl = config('services.rapidapi.movies.url');
        
        // Validação: verifica se a chave da API está configurada
        if (empty($apiKey)) {
            return view('movies.index', [
                'response' => ['results' => []],
                'currentPage' => $page,
                'hasNextPage' => false,
            ])->with('error', 'Chave de API não configurada. Verifique suas variáveis de ambiente.');
        }
        
        // Faz a requisição para a API com o parâmetro de página
        /** @var \Illuminate\Http\Client\Response $apiResponse */
        $apiResponse = Http::withHeaders([
            'x-rapidapi-host' => $apiHost,
            'x-rapidapi-key' => $apiKey,
        ])->get($apiUrl, [
            'page' => $page,
        ]);

        $response = $apiResponse->json();
        
        // Informações de paginação
        $currentPage = $page;
        $hasNextPage = isset($response['page']) && isset($response['entries']) && count($response['results'] ?? []) > 0;
        
        return view('movies.index', compact('response', 'currentPage', 'hasNextPage'));
    }

}
