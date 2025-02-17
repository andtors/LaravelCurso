<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

// fornecedores 
class Fornecedor extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'fornecedores';
    protected $fillable = ['nome', 'site', 'uf', 'email'];

}


/*
SiteContato::where(function($query) 
{ 
    $query->where('nome', 'Jorge')->orWhere('nome', 'Ana');  
})-> where(function($query) 
{
    $query->whereIn('motivo_contato', [1,2])->orWhereBetween('id', [4, 6]); 
})->get();
*/