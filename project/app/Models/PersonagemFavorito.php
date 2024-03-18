<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonagemFavorito extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'personagem_id', 'nome', 'foto'];
}
