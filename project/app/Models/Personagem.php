<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personagem extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'alcunha', 'foto', 'vinculo', 'ativo'];
}
