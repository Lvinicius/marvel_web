<?php

namespace App\Http\Controllers;

use App\Models\QuadrinhoFavorito;
use App\Models\Quadrinho;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class QuadrinhoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quadrinhos = Quadrinho::where('ativo', 1)->orderBy('titulo', 'asc')->get();
        $user = Auth::user();

        $favoritos = QuadrinhoFavorito::where('user_id', $user->id)->pluck('quadrinho_id')->toArray();

        // Para cada quadrinho, verifiqcar se tem um favorito para o usuário atual
        foreach ($quadrinhos as $quadrinho) {
            $quadrinho->favorito = in_array($quadrinho->id, $favoritos);
            if ($quadrinho->favorito) {
                $quadrinho->favorito_id = quadrinhoFavorito::where('user_id', $user->id)
                    ->where('quadrinho_id', $quadrinho->id)
                    ->value('id');
            }
        }

        return Inertia::render('Quadrinhos', [
            'quadrinhos' => $quadrinhos,
            'user' => $user
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
