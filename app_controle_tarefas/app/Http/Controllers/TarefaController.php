<?php

namespace App\Http\Controllers;

use App\Models\Tarefa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TarefaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct(){
        $this->middleware('auth');
    }
 
    public function index()
    {

        $id = Auth::user()->id;
        $name = Auth::user()->name;
        $email = Auth::user()->email;
        
        return "ID $id | Nome: $name | E-mail: $email";

       /*  if(Auth::check()){

            $id = Auth::user()->id;
            $name = Auth::user()->name;
            $email = Auth::user()->email;
            
            return "ID $id | Nome: $name | E-mail: $email";
            
           } else {
            return "Você não está logado no sistema!";
           } */

       /* if(auth()->check()){

        $id = auth()->user()->id;
        $name = auth()->user()->name;
        $email = auth()->user()->email;
        
        return "ID $id | Nome: $name | E-mail: $email";
        
       } else {
        return "Você não está logado no sistema!";
       } */
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        //
    }
}
