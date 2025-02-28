<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fornecedor;

class FornecedorController extends Controller
{
    public function index(){
        
        return view('app.fornecedor.index');

    }

    public function listar(Request $request){

        $fornecedores = Fornecedor::where('nome', 'like', '%' . $request->input('nome') . '%')
        ->where('email', 'like', '%' . $request->input('email') . '%')
        ->where('site', 'like', '%' . $request->input('site') . '%')
        ->where('uf', 'like', '%' . $request->input('uf') . '%')
        ->where('email', 'like', '%' . $request->input('email') . '%')
        ->paginate(10);

    
        return view('app.fornecedor.listar', ['fornecedores' => $fornecedores, 'request' => $request->all()]);
    }

    public function adicionar(Request $request){

        $msg = "";

        $regras = [
          'nome' => 'required|min:3|max:40',
          'site' => 'required',
          'uf' => 'required|min:2|max:2',
          'email' => 'email',
        ];

        $feedback = [
          'required' => 'O campo: :attribute deve ser preenchido',
          'nome.min' => 'O campo nome deve ter no minimo 3 caracteres',
          'nome.max' => 'O campo nome deve ter no maximo 40 caracteres',
          'uf.min' => 'O campo UF deve ter no minimo 2 caracteres',
          'uf.max' => 'O campo UF deve ter no maximo 2 caracteres',
          'email.email' => 'O campo e-mail não foi preenchido corretamente'
        ];

        if($request->getMethod() == 'POST' && $request->input('id') === null){
          
          $request->validate($regras, $feedback);

          $fornecedor = new Fornecedor();
          $fornecedor->create($request->all());

          $msg = 'Cadastro realizado com sucesso';

          return view('app.fornecedor.index', ['msg' => $msg]);
        } else if($request->getMethod() == 'POST' && $request->input('id') != null){

          $request->validate($regras, $feedback);
          
          $fornecedor = Fornecedor::find($request->input('id'));

          try{
            $fornecedor->update($request->all());
          } catch(\Throwable $e){
            $msg = 'Erro ao atualizar o registro, tente novamente';
            return view('app.fornecedor.index', ['msg' => $msg]);
          }
          
          $msg = 'Fornecedor atualizado com sucesso';
          return view('app.fornecedor.index', ['msg' => $msg]);

        } else if ($request->getMethod() == 'GET'){
          return view('app.fornecedor.adicionar', ['msg' => $msg]);
      }
    }
    public function editar($id){

      $fornecedor = Fornecedor::find($id);

      return view('app.fornecedor.adicionar', ['fornecedor' => $fornecedor]);
    }

    public function excluir($id){
      
      $msg = "";
      
      try{
        Fornecedor::find($id)->delete();
      } catch(\Throwable $e){
        $msg = 'Erro ao deletar o registro, tente novamente';
        return view('app.fornecedor.index', ['msg' => $msg]);
      }
      
      $msg = "Fornecedor deletado com sucesso";
      return view('app.fornecedor.index')->with('msg', 'Produto deletado com sucesso');
    }
}
