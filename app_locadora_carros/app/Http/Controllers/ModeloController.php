<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Modelo;
use Illuminate\Http\Request;
use App\Repositories\ModeloRepository;

class ModeloController extends Controller
{

    public function __construct(Modelo $modelo){
        $this->modelo = $modelo;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $modeloRepository = new ModeloRepository($this->modelo);

        if($request->has('atributos_marca')){
            $atributos_marca = 'marca:id,'.$request->atributos_marca;
            $modeloRepository->selectAttributosRegistrosRelacionados($atributos_marca);
        } else {
            $modeloRepository->selectAttributosRegistrosRelacionados('marca');
        }

        if($request->has('filtro')){
            $modeloRepository->filtro($request);
        }

        if($request->has('atributos')){
           $modeloRepository->selectAtributos($request->atributos);
        } 

        
        return response()->json($modeloRepository->getResultadoPaginado(3), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate($this->modelo->rules());
        // stateless

        
        $image = $request->file('imagem');
        $imagem_urn = $image->store('imagens/modelos', 'public');
        
        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);

        return response()->json($modelo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $modelo = $this->modelo->with('marca')->find($id);

        if($modelo === null){
            return response()->json(["erro" => "Recurso pesquisado não existe"] ,404);
        }

        return response()->json($modelo, 200);
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
        $modelo = $this->modelo->find($id);

        if($modelo === null){
            return response()->json(["erro" => "Impossivel realizer a atualização, o recurso solicitado não existe."],404);
        }

        if($request->method() === "PATCH"){

            $regrasDinamicas = array();

            foreach($modelo->rules() as $input => $regra){
                
                if(array_key_exists($input, $request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);
        } else {
            $request->validate($modelo->rules());
        }

        // remove o arquivo antigo caso o novo tenha sido enviado no request
        if($request->file('imagem')){
            Storage::disk('public')->delete($modelo->imagem);
        }

        $modelo->fill($request->all());
        
        if(!$request->file('imagem')){
            $image = $modelo->imagem;
        } else {
            $image = $request->file('imagem');
            $imagem_urn = $image->store('imagens', 'public');
            $modelo->imagem = $imagem_urn;
        }
    
        $modelo->save();
    
        return response()->json($modelo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);

        if($modelo === null){
            return response()->json(["erro" => "Impossivel realizer a atualização, o recurso solicitado não existe."], 404);
        }

       Storage::disk('public')->delete($modelo->imagem);
    
        $modelo->delete();

        return response()->json(['msg'  => 'O modelo foi deletada com sucesso!'], 200);
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getModeloNomeId()
    {
        $modeloRepository = new ModeloRepository($this->modelo);

        return response()->json($modeloRepository->getResultado());
    }
}
