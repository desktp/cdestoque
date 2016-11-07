<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Maquina;
use App\Fabricante;
use App\TipoMaquina;
use App\Repositories\MaquinaRepository;

class MaquinaController extends Controller
{
	protected $maquinas;

    public function __construct(MaquinaRepository $maquinas){
    	$this->middleware('auth');

    	$this->maquinas = $maquinas;
    }

    public function index(Request $request){
    	$maquinas = Maquina::orderBy('created_at', 'asc')->get();
    	$fabricantes = Fabricante::orderBy('fabricante', 'asc')->get();
    	$tipo_maquinas = TipoMaquina::orderBy('id', 'asc')->get();

    	return view('common.cadastro_2', [
    		'dados1' => $maquinas,
    		'dados2' => $fabricantes,
    		'dados3' => $tipo_maquinas,
            'obj1' => 'maquina',
            'obj2' => 'fabricante',
            'obj3' => 'tipo_maquina'
    	]);
    }

    public function store(Request $request){
    	$this->validate($request, [
    		'nome' => 'required|max: 50',
    		'fabricante_id' => 'required',
    		'tipo_maquina_id' => 'required'
    		]);

    	$maquina = new Maquina();
    	$maquina->create([
    		'nome' => $request->nome,
    		'fabricante_id' => $request->fabricante_id,
    		'tipo_maquina_id' => $request->tipo_maquina_id
    	]);

    	return redirect('/maquinas');
    }
}
