<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    use HasFactory;
    protected $fillable = ['equipe_id', 'funcionario_id', 'valor_venda'];

    public function rules()
    {
        return [
            'equipe_id' => 'exists:equipes,id',
            'funcionario_id' => 'exists:funcionarios,id',

        ];
    }

    // metodo de feedback das regras funcionario ***********************************************************************

    public function feedback()
    {
        return[
            'required' => 'O campo :attribute é obrigatório',
        ];
    }

    public function funcionario()
    {
        // uma venda pertence a um funcionario *********
        return $this->belongsTo('App\Models\Funcionario'); // pentence a
    }
}
