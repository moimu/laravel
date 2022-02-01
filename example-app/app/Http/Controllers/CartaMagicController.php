<?php

namespace App\Http\Controllers;

use App\Models\CartaMagic;
use Illuminate\Http\Request;

class CartaMagicController extends Controller
{

    public function __construct()
    {
        // necesitemos LOGIN antes de entrar a ruta
        $this -> middleware('auth');
    }

    /**
     * Display a listing of the resource.
     * Tiene sentido mostrar en el indice de la web un listado de cartas del usuario logado
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        // return response('hola mundo');
        // devuelve una instancia del autenticador  auth()
        $cartaMagics = auth()->user()->cartaMagics;   //dd($cartaMagics);
        
       //return view('carta.magic.index' , ['cartaMagics', $cartaMagics]);  // lo mismo
       return view( 'carta_magics.index' , compact('cartaMagics') );  // retornamos una vista
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = 'valor pepe 123';
        return view('carta_magics.create', ['paco' => $data]);
    }

    /**
     * Almacene un recurso recién creado en el almacenamiento.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   // dd($request);    vemos lo que se envia por el formulario
        
        // https://laravel.com/docs/8.x/queries
        $user = auth()->user(); // devuelve al usuario !autenticado! importante
        // acedemos relacion muchos de cartaMagics()
        $cartaMagic = $user-> cartaMagics()->create([   // create restorna el objeto creado
            'titulo' => $request['titulo'],
            'tipo' => 'tierra',
        ]); 

        return response(" creada la carta con id $cartaMagic->id ");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartaMagic  $cartaMagic
     * @return \Illuminate\Http\Response
     */
    public function show(CartaMagic $cartaMagic)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CartaMagic  $cartaMagic
     * @return \Illuminate\Http\Response
     */
    public function edit(CartaMagic $cartaMagic)
    {
        dd($cartaMagic);
        // $cartaMagic->id()
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartaMagic  $cartaMagic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartaMagic $cartaMagic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartaMagic  $cartaMagic
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartaMagic $cartaMagic)
    {
        //
    }
}
