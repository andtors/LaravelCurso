<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoDetalhe extends Model
{
    use HasFactory;
    protected $fillable = ['produto_id', 'comprimento', 'altura', 'largura', 'unidade_id'];

    public function produto(){
        return $this->belongsTo('App\Models\Produto');
    }

  /* 
    Faz o mesmo que o hasOne porém na tabela mais fraca
  */
}
