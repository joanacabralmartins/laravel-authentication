<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Noticia;
use Illuminate\Http\Request;

class NoticiaController extends Controller
{

    public function __construct()
    {

        //$this->middleware('auth');  este metodo nao funciona porque o modelo
        //de autenticacao do middleware auth nao eh baseado em token 
        
        //$this->authorizeResource(Noticia::class, 'noticia');
    }

    public function index(){

        return response()->json(Noticia::all());

    }

    public function store(Request $request){

        $noticia = Noticia::create($request->all());
        return response()->json($noticia, 201);

    }

    public function show(Noticia $noticia){

        //$this->authorize('view', $noticia);
        $user = auth('sanctum')->user();
        if(! $user->can('view', $noticia)){
            return response()->json('Nao Autorizado', 401);
        }

        return response()->json($noticia, 200);
    }

    public function update(Noticia $noticia, Request $request){

        $noticia->titulo = $request->titulo;   
        $noticia->descricao = $request->descricao;
        $noticia->user_id = $request->user_id;
        $noticia->save();
        
        return response()->json($noticia, 200);
    }

    public function destroy(Noticia $noticia){

        Noticia::destroy($noticia->id);

        return response()->noContent();

    }

}