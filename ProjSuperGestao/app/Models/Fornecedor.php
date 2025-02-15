<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// fornecedores

class Fornecedor extends Model
{
    use HasFactory;
    protected $table = 'fornecedores';
    protected $fillable = ['nome', 'site', 'uf', 'email'];
}

$contato4 = SiteContato::where('nome', '!=', 'Fernando')->whereIn('motivo_contato'
, [1, 2])->whereBetween('created_at', ['2025-02-15 18:07:09', '2025-02-15 18:15:04'])
->get();