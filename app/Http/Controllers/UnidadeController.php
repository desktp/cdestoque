<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Unidade;

class UnidadeController extends Controller
{
    protected $unidades;

    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(Request $request){
    	$unidades = Unidade::orderBy('created_at', 'asc')->get();

    	return view('common.cadastro_simples', [
    		'obj' => 'unidade',
            'dados' => $unidades
    	]);
    }

    public function store(Request $request){
    	$this->validate($request, [
    		'unidade' => 'required|max: 50',
    		]);

    	$unidade = new Unidade();
    	$unidade->create([
    		'unidade' => $request->unidade,
    	]);

    	return redirect('/unidades');
    }

    public function destroy(Request $request, Unidade $unidade){
    	$unidade->delete();

    	return redirect('/unidades');
    }
}
