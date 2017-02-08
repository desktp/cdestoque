<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Repositories\EstoqueRepository;
use App\Repositories\FilialRepository;
use App\Repositories\ProdutoRepository;
use App\Repositories\MarcaRepository;
use App\Repositories\UnidadeRepository;

use App\EstoqueEntrada;
use App\Estoque;
use App\EstoqueMaquina;

class EstoqueController extends Controller
{
	protected $estoque;

    public function __construct(EstoqueRepository $repository){
    	$this->middleware('auth');

    	$this->estoque = $repository;
    }

    // GET
    public function index(Request $request){
    	return view('estoque.entrada', [
    		'estoque' => $this->estoque->all(),
    	]);
    }

    public function entrada(Request $request){
    	$filiais = new FilialRepository();
    	$marcas = new MarcaRepository();
    	$produtos = new ProdutoRepository();
    	return view('estoque.entrada', [
    		'filiais' => $filiais->all(),
    		'marcas' => $marcas->all(),
    		'produtos' => $produtos->all()
    	]);
    }

    public function entradaMaquina(Request $request){
        $unidades = new UnidadeRepository();

        return view('estoque.maquina', [
            'unidades' => $unidades->all()
        ]);
    }

    public function porMarcaJson(Request $request){
        $retorno = $this->estoque->porMarca($request->marca);

        return response()->json($retorno, 200);
    }

    public function porFilialJson(Request $request){
        $retorno = $this->estoque->porFilial($request->filial);

        return response()->json($retorno, 200);
    }

    // POST
    public function store(Request $request){
    	$this->validate($request, [
    		'produto_id' => 'required',
    		'qtd' => 'required|min: 1',
    		'pcoEntrada' => 'required|min: 0.01'
    	]);

    	try{
    		DB::beginTransaction();

    		$entrada = new EstoqueEntrada();
    		$entrada->create([
	    		'produto_id' => $request->produto_id,
	    		'filial_id' => $request->filial_id,
	    		'qtd' => $request->qtd,
	    		'pcoEntrada' => str_replace(',', '.', $request->pcoEntrada)
	    	]);
    		
	    	$estoque = $this->estoque->porProdutoEFilial($request->produto_id, $request->filial_id);
	    	if($estoque == null){
	    		$estoque = new Estoque();
	    		$estoque->create([
	    			'filial_id' => $request->filial_id,
	    			'produto_id' => $request->produto_id,
	    			'qtd' => $request->qtd
	    			]);
	    	} else {
	    		$estoque->qtd += $request->qtd;
	    		$this->estoque->update($estoque);		
	    	}

	    	DB::commit();
    	} catch (\Exception $e) {
    		DB::rollback();
    		$errors = $e->getMessage();
    		return redirect('/estoque')->withErrors($errors);
    	}
    	
    	return redirect('/estoque');
    }

    public function storeEntradaMaquina(Request $request){
        $this->validate($request, [
            'maquina_id' => 'required',
            'produto_id' => 'required',
            'qtd' => 'required|min: 1',
            'mola' => 'required',
            'pcoSaida' => 'required|min: 0.01'
            ]);

        $estoqueMaquina = $this->estoque->porMaquinaEMola($request->maquina_id, $request->mola);
        

        if (!$estoqueMaquina){
            $estoqueMaquina = new EstoqueMaquina();
            $estoqueMaquina->maquina_id = $request->maquina_id;
            $estoqueMaquina->produto_id = $request->produto_id;
            $estoqueMaquina->qtd = $request->qtd;
            $estoqueMaquina->mola = $request->mola;
            $estoqueMaquina->pcoSaida = $request->pcoSaida;

            $estoqueMaquina->save();
        } 
        else if ($estoqueMaquina && $estoqueMaquina->produto_id == $request->produto_id) {
             $estoqueMaquina->qtd += $request->qtd;
             $this->estoque->updateEstoqueMaquina($estoqueMaquina);
        } 
        else {
            return response()->json("{\"erro\": \"Ja existe um produto na mola selecionada. Remover o produto antes de inserir um novo\"}", 500);
        }

        return response()->json($estoqueMaquina, 200);
    }
}
