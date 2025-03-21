<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules(){
        return  [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file|mimes:png,jpeg'
        ];

        /*
            1) tabela
            2) nome da coluna que sera pesquisado na tabela
            3) id do registro que será desconsiderado
        
        */
    }

    public function feedback(){
        return [
            'required' => 'O campo :attribute é obrigatorio',
            'imagem.mimes' => 'O arquivo deve ser do tipo png ou jpeg',
            'nome.unique' => 'O nome da marca já existe',
            'nome.min' => 'O nome deve ter no mínimo 3 caracteres'
        ];
    }

    public function modelos(){
        return $this->hasMany('App\Models\Modelo');
    }
}
