<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Maquina;
use App\MaquinaModelo;
use App\Fabricante;
use App\TipoMaquina;
use App\Unidade;
use App\Repositories\MaquinaRepository;
use App\Repositories\UnidadeRepository;
use App\Repositories\FabricanteRepository;

class MaquinaController extends Controller
{
	protected $maquinas;

    public function __construct(MaquinaRepository $maquinas){
    	$this->middleware('auth');

    	$this->maquinas = $maquinas;
    }

    // GET
    public function index(Request $request){
    	$maquina_modelos = MaquinaModelo::orderBy('created_at', 'asc')->get();
    	$fabricantes = Fabricante::orderBy('fabricante', 'asc')->get();
    	$tipo_maquinas = TipoMaquina::orderBy('id', 'asc')->get();

    	return view('common.cadastro_2', [
    		'dados1' => $maquina_modelos,
    		'dados2' => $fabricantes,
    		'dados3' => $tipo_maquinas,
            'obj1' => 'maquina_modelo',
            'obj2' => 'fabricante',
            'obj3' => 'tipo_maquina'
    	]);
    }

    public function associarUnidade(Request $request){
        $unidades = new UnidadeRepository();
        $fabricantes = new FabricanteRepository();

        return view('maquina.unidade', [
            'unidades' => $unidades->all(),
            'fabricantes' => $fabricantes->all()
        ]);
    }

    public function porUnidadeJson(Request $request){
        $retorno = $this->maquinas->maquinasPorUnidade($request->unidade);

        return response()->json($retorno, 200);
    }

    public function porFabricanteJson(Request $request){
        $retorno = $this->maquinas->modelosPorFabricante($request->fabricante);

        return response()->json($retorno,200);
    }

    public function getModeloJson(Request $request){
        $retorno = $this->maquinas->getModelo($request->maquina_modelo);
        
        return response()->json($retorno, 200);
    }

    // POST
    public function store(Request $request){
        $this->validate($request, [
            'nome' => 'required|max: 50',
            'fabricante_id' => 'required',
            'tipo_maquina_id' => 'required'
            ]);

        $maquina = new MaquinaModelo();
        $maquina->create([
            'nome' => $request->nome,
            'fabricante_id' => $request->fabricante_id,
            'tipo_maquina_id' => $request->tipo_maquina_id
        ]);

        return redirect('/maquinas');
    }

    public function storeAssociarUnidade(Request $request){
        $this->validate($request, [
            'unidade_id' => 'required',
            'maquina_modelo_id' => 'required',
            'apelido' => 'required'
        ]);

        $maquina = new Maquina();
        $maquina->create([
            'unidade_id' => $request->unidade_id,
            'maquina_modelo_id' => $request->maquina_modelo_id,
            'apelido' => $request->apelido
        ]);

        return redirect ('/maquinas/unidades');
    }


}
