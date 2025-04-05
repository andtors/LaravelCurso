<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carro;
use App\Repositories\CarroRepository;

class CarroController extends Controller
{

    public function __construct(Carro $carro) {
        $this->carro = $carro;
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $carroRepository = new CarroRepository($this->carro);

        if($request->has('atributos_modelo')){
            $atributos_modelo = 'modelo:id,'.$request->atributos_modelo;
            $carroRepository->selectAttributosRegistrosRelacionados($atributos_modelo);
        } else {
            $carroRepository->selectAttributosRegistrosRelacionados('modelo');
        }

        if($request->has('filtro')){
            $carroRepository->filtro($request);
        }

        if($request->has('atributos')){
           $carroRepository->selectAtributos($request->atributos);
        } 

        return response()->json($carroRepository->getResultadoPaginado(3), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate($this->carro->rules());
        // stateless

        $carro = $this->carro->create([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $request->disponivel,
            'km' => $request->km
        ]);

        return response()->json($carro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $carro = $this->carro->with('modelo')->with('locacoes')->find($id);

        if($carro === null){
            return response()->json(["erro" => "Recurso pesquisado não existe"] ,404);
        }

        return response()->json($carro, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $carro = $this->carro->find($id);

        if($carro === null){
            return response()->json(["erro" => "Impossivel realizer a atualização, o recurso solicitado não existe."],404);
        }

        if($request->method() === "PATCH"){

            $regrasDinamicas = array();

            foreach($carro->rules() as $input => $regra){
                
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);
        } else {
            $request->validate($carro->rules());
        }

        $carro->fill($request->all());
    
        $carro->save();
    
        return response()->json($carro, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $carro = $this->carro->find($id);

        if($carro === null){
            return response()->json(["erro" => "Impossivel realizer a atualização, o recurso solicitado não existe."], 404);
        }
    
        $carro->delete();

        return response()->json(['msg'  => 'O carro foi deletada com sucesso!'], 200);
    }

    public function getCarroNomeId()
    {
        $carros = $this->carro->with('modelo')->get();

        return response()->json($carros);
    }
}
