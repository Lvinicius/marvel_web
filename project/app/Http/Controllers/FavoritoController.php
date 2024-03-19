<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use App\Models\PersonagemFavorito;
use App\Models\QuadrinhoFavorito;

class FavoritoController extends Controller
{
    public function index()
    {
        $personagens = PersonagemFavorito::orderBy('alcunha', 'asc')->get();
        $quadrinho  = QuadrinhoFavorito::orderBy('titulo', 'asc')->get();
        $user = Auth::user();

        return Inertia::render('Favoritos', [
            'personagens' => $personagens,
            'quadrinhos' => $quadrinho,
            'user' => $user
        ]);
    }

    public function storePersonagem(Request $request)
    {
        $validate=$request->validate([
            'user_id'=>'required',
            'personagem_id'=>'required',
            'alcunha'=>'required',
            'foto'=>'required'
        ]); 

        PersonagemFavorito::create($validate);
    }

    public function storeQuadrinho(Request $request)
    {
        $validate=$request->validate([
            'user_id'=>'required',
            'quadrinho_id'=>'required',
            'titulo'=>'required',
            'capa'=>'required'
        ]); 

        QuadrinhoFavorito::create($validate);
    }

    public function destroyPersonagem( $id)
    {
        $favorito = PersonagemFavorito::findOrFail($id);
        if($favorito){
            $favorito->delete();
        }else{
            return response()->json(['error' => 'Erro no envio da foto'], 400);
        }
    }

    public function destroyQuadrinho($id)
    {
        $favorito = QuadrinhoFavorito::findOrFail($id);
        if($favorito){
            $favorito->delete();
        }else{
            return response()->json(['error' => 'Erro no envio da foto'], 400);
        }
    }
}
