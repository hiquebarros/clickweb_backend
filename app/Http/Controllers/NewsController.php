<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $news = News::orderBy('created_at', 'desc')->paginate(5);
        return view('news.index', compact('news'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('news.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|min:3',
            'content' => 'required|string|min:10|max:50000',
            'author' => 'required|string|max:255|min:2',
            'published_at' => 'nullable|date|before_or_equal:now',
        ], [
            'title.required' => 'O título é obrigatório.',
            'title.min' => 'O título deve ter pelo menos 3 caracteres.',
            'title.max' => 'O título não pode exceder 255 caracteres.',
            'content.required' => 'O conteúdo é obrigatório.',
            'content.min' => 'O conteúdo deve ter pelo menos 10 caracteres.',
            'content.max' => 'O conteúdo não pode exceder 50.000 caracteres.',
            'author.required' => 'O autor é obrigatório.',
            'author.min' => 'O nome do autor deve ter pelo menos 2 caracteres.',
            'author.max' => 'O nome do autor não pode exceder 255 caracteres.',
            'published_at.date' => 'A data de publicação deve ser uma data válida.',
            'published_at.before_or_equal' => 'A data de publicação não pode ser no futuro.',
        ]);

        // Sanitização adicional
        $validated['title'] = strip_tags($validated['title']);
        $validated['author'] = strip_tags($validated['author']);
        // Permitir HTML básico no conteúdo, mas remover scripts
        $validated['content'] = strip_tags($validated['content'], '<p><br><strong><em><ul><ol><li><a><h1><h2><h3><h4><h5><h6>');

        News::create($validated);

        return redirect()->route('news.index')
            ->with('success', 'Notícia cadastrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $news = News::findOrFail($id);
        return view('news.show', compact('news'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $news = News::findOrFail($id);
        return view('news.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $news = News::findOrFail($id);
        
        $validated = $request->validate([
            'title' => 'required|string|max:255|min:3',
            'content' => 'required|string|min:10|max:50000',
            'author' => 'required|string|max:255|min:2',
            'published_at' => 'nullable|date|before_or_equal:now',
        ], [
            'title.required' => 'O título é obrigatório.',
            'title.min' => 'O título deve ter pelo menos 3 caracteres.',
            'title.max' => 'O título não pode exceder 255 caracteres.',
            'content.required' => 'O conteúdo é obrigatório.',
            'content.min' => 'O conteúdo deve ter pelo menos 10 caracteres.',
            'content.max' => 'O conteúdo não pode exceder 50.000 caracteres.',
            'author.required' => 'O autor é obrigatório.',
            'author.min' => 'O nome do autor deve ter pelo menos 2 caracteres.',
            'author.max' => 'O nome do autor não pode exceder 255 caracteres.',
            'published_at.date' => 'A data de publicação deve ser uma data válida.',
            'published_at.before_or_equal' => 'A data de publicação não pode ser no futuro.',
        ]);

        // Sanitização adicional
        $validated['title'] = strip_tags($validated['title']);
        $validated['author'] = strip_tags($validated['author']);
        // Permitir HTML básico no conteúdo, mas remover scripts
        $validated['content'] = strip_tags($validated['content'], '<p><br><strong><em><ul><ol><li><a><h1><h2><h3><h4><h5><h6>');

        $news->update($validated);

        return redirect()->route('news.show', $news->id)
            ->with('success', 'Notícia atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $news = News::findOrFail($id);
        $news->delete();

        return redirect()->route('news.index')
            ->with('success', 'Notícia excluída com sucesso!');
    }
}
