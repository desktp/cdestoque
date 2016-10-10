<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Fabricante;

class FabricanteController extends Controller
{
    protected $fabricantes;

    public function __construct(){
    	$this->middleware('auth');
    }

    public function index(Request $request){
    	$fabricantes = Fabricante::orderBy('created_at', 'asc')->get();

    	return view('fabricantes.index', [
    		'fabricantes' => $fabricantes
    	]);
    }

    public function store(Request $request){
    	$this->validate($request, [
    		'fabricante' => 'required|max: 50',
    		]);

    	$fabricante = new Fabricante();
    	$fabricante->create([
    		'fabricante' => $request->fabricante,
    	]);

    	return redirect('/fabricantes');
    }

    public function destroy(Request $request, Fabricante $fabricante){
    	$fabricante->delete();

    	return redirect('/fabricantes');
    }


}
