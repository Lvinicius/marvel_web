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
        $personagens = Personagem::where('ativo', 1)->orderBy('nome', 'asc')->get();

        return Inertia::render('Personagens', [
            'personagens' => $personagens
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

        // Salva a imagem na pasta 'uploads' e obtém o caminho relativo
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            $nomeArquivo = $request->file('foto')->getClientOriginalName(); 
            $path = $request->file('foto')->storeAs('uploads', $nomeArquivo, 'public'); 
            $validate['foto'] = $path;
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
    public function update(Request $request, $id)
    {   
        // Busca o Personagem pelo ID
        $personagem = Personagem::findOrFail($id);

        if(!$personagem) {
            return response()->json(['error' => 'Personagem não encontrado'], 404);
        }else{
            $validate = $request->validate([ 
                'nome' => 'required',
                'alcunha' => 'required',
                'vinculo' => 'required',
                'foto' => 'sometimes|file|mimes:jpeg,png,jpg,gif,svg|max:2048' 
            ]);
        
            // Se uma nova foto foi enviada, salva a nova imagem na pasta 'uploads' e atualiza o caminho relativo
            if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
                $nomeArquivo = $request->file('foto')->getClientOriginalName(); 
                $path = $request->file('foto')->storeAs('uploads', $nomeArquivo, 'public'); 
                $validate['foto'] = $path;
            }
            
            // Atualiza os dados do personagem
            $personagem->update($validate);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personagem $personagem)
    {
        $personagem->update(['ativo' => 0]);
    }
}
