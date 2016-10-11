<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Filial;

class FilialController extends Controller
{
    protected $filiais;

    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(Request $request){
        $dados = Filial::orderBy('created_at', 'asc')->get();

        return view('common.cadastro_simples', [
            'obj' => 'filial',
            'dados' => $dados
        ]);
    }

    public function store(Request $request){
    	$this->validate($request, [
    		'filial' => 'required|max: 50',
    		]);

    	$filial = new Filial();
    	$filial->create([
    		'filial' => $request->filial,
    	]);

    	return redirect('/filials');
    }

    public function destroy(Request $request, Filial $filial){
    	$filial->delete();

    	return redirect('/filials');
    }    
}
