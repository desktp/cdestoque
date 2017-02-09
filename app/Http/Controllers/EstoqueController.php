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
use App\EstoqueSaida;

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
        $filiais = new FilialRepository();

        return view('estoque.maquina', [
            'unidades' => $unidades->all(),
            'filiais' => $filiais->all()
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

    public function getAllEstoqueMaquinaJson(Request $request){
        $retorno = $this->estoque->getAllEstoqueMaquina($request->maquina);

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

            // Registra entrada no estoque
    		$entrada = new EstoqueEntrada();
    		$entrada->create([
	    		'produto_id' => $request->produto_id,
	    		'filial_id' => $request->filial_id,
	    		'qtd' => $request->qtd,
	    		'pcoEntrada' => str_replace(',', '.', $request->pcoEntrada)
	    	]);
    		
            // Verifica se produto já existe na filial indicada
	    	$estoque = $this->estoque->porProdutoEFilial($request->produto_id, $request->filial_id);

            // Se não, registra produto novo
	    	if($estoque == null){
	    		$estoque = new Estoque();
	    		$estoque->create([
	    			'filial_id' => $request->filial_id,
	    			'produto_id' => $request->produto_id,
	    			'qtd' => $request->qtd
	    			]);
	    	} else { // Ou apenas atualiza quantidade
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
            'estoqueMaquina.maquina_id' => 'required',
            'estoqueMaquina.produto_id' => 'required',
            'estoqueMaquina.qtd' => 'required|min: 1',
            'estoqueMaquina.mola' => 'required',
            'estoqueMaquina.pcoSaida' => 'required|min: 0.01',
            'filial.id' => 'required'
            ]);

        $entrada = new EstoqueMaquina([
            'maquina_id' => $request->estoqueMaquina['maquina_id'],
            'produto_id' => $request->estoqueMaquina['produto_id'],
            'qtd' => $request->estoqueMaquina['qtd'],
            'mola' => $request->estoqueMaquina['mola'],
            'pcoSaida' => $request->estoqueMaquina['pcoSaida']
            ]);

        $estoqueSaida = new EstoqueSaida([
            'maquina_id' => $entrada->maquina_id,
            'produto_id' => $entrada->produto_id,
            'filial_id' => $request->filial['id'],
            'qtd' => $entrada->qtd,
            'pcoSaida' => $entrada->pcoSaida
            ]);

        try{
            DB::beginTransaction();

            $estoqueAtual = $this->estoque->porProdutoEFilial($entrada->produto_id, $estoqueSaida->filial_id);

            if ($estoqueAtual){
                // Verifica se já existe produto na mola especificada
                $estoqueMaquina = $this->estoque->porMaquinaEMola($entrada);
                
                // Se não, registra entrada do produto
                if (!$estoqueMaquina){
                    $entrada->save();
                } 
                else if ($estoqueMaquina && $estoqueMaquina->produto_id == $entrada->produto_id) { // Ou atualiza quantidade do produto existente
                     $estoqueMaquina->qtd += $entrada->qtd;
                     $estoqueMaquina->save();
                } 
                else { // Ou retorna erro
                    return response()->json(['error' => 'Já existe produto na mola selecionada. Remover ou alterar diretamente o produto.4'], 500);
                }

                $estoqueSaida->save();

                $estoqueAtual->qtd -= $estoqueSaida->qtd;
                $this->estoque->updateQtd($estoqueAtual);

                DB::commit();
            }  
        }
        catch (Exception $e){
            DB::rollback();
            $errors = $e->getMessage();
            return response()->json(['error' => $errors]);
        }

        return response()->json($entrada, 200);
    }
}
