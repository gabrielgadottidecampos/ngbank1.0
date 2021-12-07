<?php

namespace App\Http\Controllers;

use App\Models\Venda;
use App\Repositories\VendaRepository;
use Illuminate\Http\Request;

class VendaController extends Controller
{
    // contrutor para setar o classe funcionario
    public function __construct(Venda $venda){
        $this->venda = $venda;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $vendaRepository = new VendaRepository($this->venda);
        if($request->has('$atributos_funcionario')){
            $atributos_funcionario = $request->atributos_equipe;
            $vendaRepository->selectAtributosRegistrosRelacionados('equipe:id,'.$atributos_funcionario);

        }else{
            $vendaRepository->selectAtributosRegistrosRelacionados('funcionario');
        }

//filtros --------------------------------------------------------------------------------------------------------------
        if($request->has('filtro')){

            $vendaRepository->filtro($request->filtro);
        }
//atributos ------------------------------------------------------------------------------------------------------------
        if($request->has('atributos')){
            $vendaRepository->selectAtributos($request->atributos);
        }
//------------------------------------------------------------------

        return response()->json($vendaRepository->getResultadoPaginado(10),200);
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // regras e feedbak de validações *************************

        $request->validate($this->venda->rules(), $this->venda->feedback());


        $venda = $this->venda->create([
            'equipe_id' => $request ->equipe_id,
            'funcionario_id' => $request ->funcionario_id,
            'valor_venda' => $request->valor_venda,

        ]);
        return response()->json($venda,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $venda = $this->venda->with('venda')->find($id);
        // validação da pesquisa ************************
        if($venda === null){
            return response()->json(['erro' => 'O Funcionario pesquisado não existe'],404);
        }
        return response()->json($venda, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $venda = $this->venda->find($id);
        //validação do update **************
        if($venda === null){
            return response()->json(['erro' => 'Impossivel realizar a solucitação. O Funcionario pesquisado não existe'], 401);
        }
        // validação do metodo da requisição para impor as regras e feedback *********
        if($request->method() === 'PATCH'){
            $regrasDinamicas = array();

            foreach ($venda->rules() as $input => $regra){
                if (array_key_exists($input,$request->all())){
                    $regrasDinamicas[$input] = $regra;
                }
            }
            $request->validate($regrasDinamicas, $venda->feedback());
        }else{
            $request->validate($this->venda->rules(), $venda->feedback());
        }
        $venda->fill($request->all());
        $venda->save();
        return response()->json($venda, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Venda  $venda
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $venda = $this->venda->find($id);
        // validação do metodo destroy ********
        if($venda === null){
            return response()->json(['erro' => 'Impossivel excluir o funcionario. O Funcionaario pesquisado não existe'],401);
        }

        $venda->delete();
        return response()->json(['msg' => 'O Funcionario foi removida com sucesso'],200);
    }
}
