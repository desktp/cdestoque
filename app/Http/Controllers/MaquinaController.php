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
    	$tipoMaquinas = TipoMaquina::orderBy('id', 'asc')->get();

    	return view('maquinas.index', [
    		'maquinas' => $maquinas,
    		'fabricantes' => $fabricantes,
    		'tipoMaquinas' => $tipoMaquinas
    	]);
    }

    public function store(Request $request){
    	$this->validate($request, [
    		'modelo' => 'required|max: 50',
    		'fabricante_id' => 'required',
    		'tipoMaquina_id' => 'required'
    		]);

    	$maquina = new Maquina();
    	$maquina->create([
    		'modelo' => $request->modelo,
    		'fabricante_id' => $request->fabricante_id,
    		'tipoMaquina_id' => $request->tipoMaquina_id
    	]);

    	return redirect('/maquinas');
    }
}
