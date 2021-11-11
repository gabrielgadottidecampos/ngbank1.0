<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;

class EquipeController extends Controller
{
    // metodo construtor ***********************************************************************************************
    public function __construct(Equipe $equipe)
    {
        $this->equipe = $equipe;
    }
    // fim do metodo contrutor -----------------------------------------------------------------------------------------

    // Metodo Index ****************************************************************************************************
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipes = $this->equipe->all();
        return $equipes;
    }
    //Fim metodo index -------------------------------------------------------------------------------------------------

    //Metodo Store *****************************************************************************************************
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


        $request->validate($this->equipe->rules(), $this->equipe->feedback()); // puxa da classe rules e feedback as regras

        $equipe = $this->equipe->create($request->all());
        return response()->json($equipe,200);
    }
    // fim metodo store ------------------------------------------------------------------------------------------------

    //Metodo Show ******************************************************************************************************
    /**
     * Display the specified resource.
     *
     * @param  integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $equipe = $this->equipe->find($id);
        if($equipe === null){ // validação para verificar se o resquist é valido
            return  response()->json(['erro' => 'Recursos pesquisado não existe'],404);
        }
        return response()->json($equipe,200);
    }
    // fim metodo show -------------------------------------------------------------------------------------------------

    //Metodo Update ****************************************************************************************************
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $equipe = $this->equipe->find($id);

        if($equipe === null){ // validação para verificar se o resquist é valido
            return response()->json(['eroo' => 'Impossível realizar a atualização. O recurso solicitado não existe',404]);
        }
        $equipe->update($request->all());
        return response()->json($equipe,200);
    }
    // fim metodo update -----------------------------------------------------------------------------------------------

    // Metodo Destroy **************************************************************************************************
    /**
     * Remove the specified resource from storage.
     *
     * @param  integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $equipe = $this->equipe->find($id);
        if($equipe === null){ // validação para verificar se o resquist é valido
            return response()->json(['eroo' => 'Impossível realizar a exclusão. O recurso solicitado não existe'],404);
        }
        $equipe->delete();
        return response()->json( ['msg' => 'A Equipe foi removida com sucesso'],200);
    }
    // fim metodo destroy ----------------------------------------------------------------------------------------------
}
