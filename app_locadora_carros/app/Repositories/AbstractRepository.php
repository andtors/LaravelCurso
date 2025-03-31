<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRepository {

    public function __construct(Model $model){
        $this->model = $model;
    }

    public function selectAttributosRegistrosRelacionados($atributos){
       $this->model = $this->model->with($atributos);
       // a query está sendo montada
    }
    
    public function filtro($request){
        $filtros = explode(';', $request->filtro);

            foreach($filtros as $key => $condicao){
                $c = explode(':', $request->filtro);
                $this->model = $this->model->where($c[0], $c[1], $c[2]);
                // a query está sendo montada
            }
    }

    public function selectAtributos($atributos){
        $this->model = $this->model->selectRaw($atributos);
    }

    public function getResultado(){
        return $this->model->get();
    }

    public function getResultadoPaginado($numeroRegistroPorPagina){
        return $this->model->paginate($numeroRegistroPorPagina);
    }
}
?>