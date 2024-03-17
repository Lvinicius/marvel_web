<?php

namespace App\Http\Controllers;

use App\Models\Quadrinho;
use Illuminate\Http\Request;
use Inertia\Inertia;

class QuadrinhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quadrinhos = Quadrinho::where('ativo', 1)->orderBy('titulo', 'asc')->get();

        return Inertia::render('Quadrinhos', [
            'quadrinhos' => $quadrinhos
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'titulo' => 'required',
            'edicao' => 'required',
            'ano' => 'required',
            'autor' => 'required',
            'capa' => 'file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
        ]);   
            
        // Salva a imagem na pasta 'uploads' e obtém o caminho relativo
        if ($request->hasFile('capa') && $request->file('capa')->isValid()) {
            $nomeArquivo = $request->file('capa')->getClientOriginalName(); 
            $path = $request->file('capa')->storeAs('uploads', $nomeArquivo, 'public'); 
            $validate['capa'] = $path;
        }
    
        Quadrinho::create($validate);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quadrinho $quadrinho)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quadrinho $quadrinho)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Busca o Quadrinho pelo ID
        $quadrinho = Quadrinho::findOrFail($id);

        if(!$quadrinho) {
            return response()->json(['error' => 'Quadrinho não encontrado'], 404);
        }else{
            $validate = $request->validate([
                'titulo' => 'required',
                'edicao' => 'required',
                'ano' => 'required',
                'autor' => 'required',
                'capa' => 'file|mimes:jpeg,png,jpg,gif,svg,webp|max:2048'
            ]);   
                
            // Salva a imagem na pasta 'uploads' e obtém o caminho relativo
            if ($request->hasFile('capa') && $request->file('capa')->isValid()) {
                $nomeArquivo = $request->file('capa')->getClientOriginalName(); 
                $path = $request->file('capa')->storeAs('uploads', $nomeArquivo, 'public'); 
                $validate['capa'] = $path;
            }

            $quadrinho->update($validate);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quadrinho $quadrinho)
    {
        $quadrinho->update(['ativo' => false]);
    }
}
