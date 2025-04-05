<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Repositories\ClienteRepository;


class ClienteController extends Controller
{

    public function __construct(Cliente $cliente) {
        $this->cliente = $cliente;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        if($request->has('filtro')){
            $clienteRepository->filtro($request);
        }

        if($request->has('atributos')){
           $clienteRepository->selectAtributos($request->atributos);
        } 

        return response()->json($clienteRepository->getResultado(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->cliente->rules());
        // stateless

        $cliente = $this->cliente->create([
            'nome' => $request->nome
        ]);

        return response()->json($cliente, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cliente = $this->cliente->with('locacoes')->find($id);

        if($cliente === null){
            return response()->json(["erro" => "Recurso pesquisado não existe"] ,404);
        }

        return response()->json($cliente, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * 
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cliente = $this->cliente->find($id);

        if($cliente === null){
            return response()->json(["erro" => "Impossivel realizer a atualização, o recurso solicitado não existe."],404);
        }

        if($request->method() === "PATCH"){

            $regrasDinamicas = array();

            foreach($cliente->rules() as $input => $regra){
                
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);
        } else {
            $request->validate($cliente->rules());
        }

        $cliente->fill($request->all());
    
        $cliente->save();
    
        return response()->json($cliente, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cliente = $this->cliente->find($id);

        if($cliente === null){
            return response()->json(["erro" => "Impossivel realizer a atualização, o recurso solicitado não existe."], 404);
        }
    
        $cliente->delete();

        return response()->json(['msg'  => 'O Cliente foi deletada com sucesso!'], 200);
    }

    public function getClienteNomeId()
    {
        $clienteRepository = new ClienteRepository($this->cliente);

        return response()->json($clienteRepository->getResultado());
    }
}
