<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Produto;
use App\Models\ProdutoDetalhe;
use App\Models\Unidade;
use App\Models\Fornecedor;
use Illuminate\Http\Request;

class ProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $produtos = Item::with(['itemDetalhe', 'fornecedor'])->paginate(10);

       /*  foreach($produtos as $key => $produto){

            $produtoDetalhe = ProdutoDetalhe::where('produto_id', $produto->id)->first();
            if(isset($produtoDetalhe)){
                $produtos[$key]['comprimento'] = $produtoDetalhe->comprimento;
                $produtos[$key]['largura'] = $produtoDetalhe->largura;
                $produtos[$key]['altura'] = $produtoDetalhe->altura;
            }    
        } */ 

        return view('app.produto.index', ['produtos' => $produtos, 'request' => $request->all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $unidades = Unidade::all();
        $fornecedores = Fornecedor::all();
        return view('app.produto.create', ['unidades' => $unidades, 'fornecedores' => $fornecedores]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $msg = "";

        $regras = [
          'nome' => 'required|min:3|max:40',
          'descricao' => 'required',
          'peso' => 'integer',
          'unidade_id' => 'exists:unidades,id',
          'fornecedor_id' => 'exists:fornecedores,id',
        ];

        $feedback = [
          'required' => 'O campo: :attribute deve ser preenchido',
          'nome.min' => 'O campo nome deve ter no minimo 3 caracteres',
          'nome.max' => 'O campo nome deve ter no maximo 40 caracteres',
          'peso.integer' => 'O campo peso deve ser um número inteiro',
          'unidade_id.exists' => 'A unidade de medida informada não existe',
          'fornecedor_id.exists' => 'O fornecedor informado não existe',
        ];

        $request->validate($regras, $feedback);
        
        Item::create($request->all());
        $msg = "Produto cadastrado com sucesso";

        $produtos = Item::with(['fornecedor'])->paginate(10);
        return view('app.produto.index', ['produtos' => $produtos,'msg' => $msg, 'request' => $request->all()]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function show(Produto $produto)
    {
        return view('app.produto.show', ['produto' => $produto]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $produto)
    {
        $unidades = Unidade::all();
        $fornecedores = Fornecedor::all();
        return view('app.produto.edit', ['produto' => $produto, 'unidades' => $unidades, 'fornecedores' => $fornecedores]);
        //return view('app.produto.create', ['produto' => $produto, 'unidades' => $unidades]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Item  $produto
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $produto)
    {

        $regras = [
            'nome' => 'required|min:3|max:40',
            'descricao' => 'required',
            'peso' => 'integer',
            'unidade_id' => 'exists:unidades,id',
            'fornecedor_id' => 'exists:fornecedores,id',
          ];
  
          $feedback = [
            'required' => 'O campo: :attribute deve ser preenchido',
            'nome.min' => 'O campo nome deve ter no minimo 3 caracteres',
            'nome.max' => 'O campo nome deve ter no maximo 40 caracteres',
            'peso.integer' => 'O campo peso deve ser um número inteiro',
            'unidade_id.exists' => 'A unidade de medida informada não existe',
            'fornecedor_id.exists' => 'O fornecedor informado não existe',
          ];
  
        $request->validate($regras, $feedback);
        $produto->update($request->all());
        $msg = 'Produto atualizado com sucesso';
        return redirect()->route('produto.show', ['produto' => $produto->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produto  $produto
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produto $produto)
    {
        $produto->delete();
        return redirect()->route('produto.index');
    }

}
