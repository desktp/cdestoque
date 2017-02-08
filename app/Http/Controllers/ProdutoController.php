<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Produto;
use App\Marca;
use App\TipoProduto;
use App\Repositories\ProdutoRepository;

class ProdutoController extends Controller
{
	protected $produtos;

    public function __construct(ProdutoRepository $produtos){
    	$this->middleware('auth');

    	$this->produtos = $produtos;
    }

    public function index(Request $request){
        $produtos = Produto::orderBy('created_at', 'asc')->get();
        $marcas = Marca::orderBy('marca', 'asc')->get();
        $tipo_produtos = TipoProduto::orderBy('id', 'asc')->get();

        return view('common.cadastro_2', [
            'dados1' => $produtos,
            'dados2' => $marcas,
            'dados3' => $tipo_produtos,
            'obj1' => 'produto',
            'obj2' => 'marca',
            'obj3' => 'tipo_produto'
        ]);
    }

    public function store(Request $request){
    	$this->validate($request, [
    		'nome' => 'required|max: 50',
    		'marca_id' => 'required',
    		'tipo_produto_id' => 'required'
    		]);

    	$maquina = new Produto();
    	$maquina->create([
    		'nome' => $request->nome,
    		'marca_id' => $request->marca_id,
    		'tipo_produto_id' => $request->tipo_produto_id
    	]);

    	return redirect('/produtos');
    }

    public function porMarcaJson(Request $request){
        return response()->json($this->produtos->porMarca($request->marca), 200);
    }

    public function porIDJson(Request $request){
        return response()->json($this->produtos->porID($request->produto));
    }
}
