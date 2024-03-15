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
        return Inertia::render('Personagens');
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
            'vinculo'=>'required'
        ]);

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
