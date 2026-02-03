<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MoviesController extends Controller
{
    public function index(Request $request)
    {
        $response = Http::withHeaders([
            'x-rapidapi-host' => 'moviesdatabase.p.rapidapi.com',
            'x-rapidapi-key' => 'eb7d2c7e86mshf7ebce062fd8f29p1c6a27jsn9679c95cfdef',
        ])->get('https://moviesdatabase.p.rapidapi.com/titles');

        $response = $response->json();
        return view('movies.index', compact('response'));
    }

}
