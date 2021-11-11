<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        //validação do update **************
        if($equipe === null){
            return response()->json(['erro' => 'Impossivel realizar a solucitação. A Equipe pesquisado não existe'], 401);
        }
        // validação do metodo da requisição para impor as regras e feedback *********
        if($request->method() === 'PATCH'){
            $regrasDinamicas = array();
            foreach ($equipe->rules() as $input => $regra){
                if (array_key_exists($input,$request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $this->equipe->feedback());
        }else{
            $request->validate($this->equipe->rules(), $this->equipe->feedback());
        }
        // remove o arquivo antigo caso o novo arquivo tenha sido enviado ***********
        if($request->file('imagem')){
            Storage::disk('public')->delete($equipe->imagem);
        }

        // salvando imagem ******************************************
        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/equipes', 'public');

        //preecher o objeto $equipe com os dados do request
        $equipe->fill($request->all());
        $equipe->imagem = $imagem_urn;
        $equipe->save();
        // $equipe->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);
        return response()->json($equipe, 200);
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
        // validação do metodo destroy ********
        if($equipe === null){
            return response()->json(['erro' => 'Impossivel excluir a equipe. A Equipe pesquisado não existe'],401);
        }

        // remove o arquivo antigo caso o novo arquivo tenha sido enviado ***********
        Storage::disk('public')->delete($equipe->imagem);

        $equipe->delete();
        return response()->json(['msg' => 'A Equipe foi removida com sucesso'],200);
    }
    // fim metodo destroy ----------------------------------------------------------------------------------------------
}
