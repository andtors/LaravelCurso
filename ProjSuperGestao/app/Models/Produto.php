<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'descricao', 'peso', 'unidade_id'];

    public function produtoDetalhe(){
        return $this->hasOne('App\Models\ProdutoDetalhe');

        /*
            Eloquent procura na tabela ProdutoDetalhe a fk produto_id
            e retorna o resultado numa nova array de Produto
        */
    }
}
