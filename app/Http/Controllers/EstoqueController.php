<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests;
use App\Repositories\EstoqueRepository;
use App\Repositories\FilialRepository;
use App\Repositories\ProdutoRepository;
use App\Repositories\MarcaRepository;

use App\EstoqueEntrada;
use App\Estoque;

class EstoqueController extends Controller
{
	protected $estoque;

    public function __construct(EstoqueRepository $repository){
    	$this->middleware('auth');

    	$this->estoque = $repository;
    }

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

    public function porMarcaJson(Request $request){
    	$retorno = $this->estoque->porMarca($request->marca);

    	return response()->json($retorno, 200);
    }

    public function porFilialJson(Request $request){
    	$retorno = $this->estoque->porFilial($request->filial);

    	return response()->json($retorno, 200);
    }
}
