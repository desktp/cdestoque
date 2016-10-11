<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\marca;

class MarcaController extends Controller
{
    protected $marcas;

    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(Request $request){
        $dados = Marca::orderBy('created_at', 'asc')->get();

        return view('common.cadastro_simples', [
            'obj' => 'marca',
            'dados' => $dados
        ]);
    }

    public function store(Request $request){
    	$this->validate($request, [
    		'marca' => 'required|max: 50',
    		]);

    	$marca = new Marca();
    	$marca->create([
    		'marca' => $request->marca,
    	]);

    	return redirect('/marcas');
    }

    public function destroy(Request $request, Marca $marca){
    	$marca->delete();

    	return redirect('/marcas');
    }


}
