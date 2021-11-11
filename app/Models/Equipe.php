<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipe extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    // metodo para criação de regras ***********************************************************************************
    public function rules()
    {
        return [
            'nome' => 'required|min:3',
            'imagem' => 'required|file|mimes:png,jpeg,jpg'
        ];
    }
    // fim metodo criação de regras ------------------------------------------------------------------------------------

    // metodo para criação de feedback *********************************************************************************
    public function feedback()
    {
        return [
            'required' => 'O campo :attribute é obrigatório',
            'imagem.mimes' => 'O Arquivo deve ser .png, jpg, jpeg',
            'nome.min' => 'O nome deve conter no minimo 3 caracteres'
        ];
    }
    // fim metodo criação de feedback-----------------------------------------------------------------------------------
}
