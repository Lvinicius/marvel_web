<?php

namespace App\Http\Controllers;

use App\Models\Personagem;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PersonagemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Personagens', [
            'personagens' => Personagem::orderBy('nome', 'asc')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate=$request->validate([
            'nome'=>'required',
            'alcunha'=>'required',
            'vinculo'=>'required',
            'foto'=>'file|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        //tratamento da imagem, conversão para base64
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $conteudo = file_get_contents($request->file('foto')->path());
            $validate['foto'] = base64_encode($conteudo);
        } else {
            return response()->json(['error' => 'Erro no envio da foto'], 400);
        }

        Personagem::create($validate);
    }

    /**
     * Display the specified resource.
     */
    public function show(Personagem $personagem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personagem $personagem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Personagem $personagem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personagem $personagem)
    {
        //
    }
}
