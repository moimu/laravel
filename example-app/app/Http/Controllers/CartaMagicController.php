<?php

namespace App\Http\Controllers;

use App\Models\CartaMagic;
use Illuminate\Http\Request;

// use App\Models\Users;  // usamos un metodo helpers para validar user
use Illuminate\Validation\Rule;

use Intervention\Image\Facades\Image;   // biblioteca procesar imagenes para php https://image.intervention.io/v2/introduction/installation#integration-in-laravel

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
     * para crear cartas, http://localhost/carta_magics/create damos al submit del form en vista create.blade accedemos al store
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)   
    {   // dd($request);    vemos lo que se envia por el formulario
        
        // mirar si el titulo de la carta enviado ya existe en bd para el usuario 
        $cartaMagic = auth()->user()->cartaMagics()->where('titulo', $request->titulo)->first();
        if( $cartaMagic ){
            return back()
            ->withErrors(['titulo' => 'Ya tienes una carta con ese título'])    // mensaje informativo error rojo
            ->withInput(['titulo' => $request->titulo])        // mostrar en input valor carta existente errorena de insercion
        ;  
        }
        else{
            dd('puedes seguir adelante');
        }
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
     * Ver lo que la funcion recibe y no guiarse por lo que esta escrito 
     * public function edit( Request $request )
     *
     * @param  \App\Models\CartaMagic  $cartaMagic
     * @return \Illuminate\Http\Response
     */
    public function edit(CartaMagic $cartaMagic, Request $request)
    {   //dd($cartaMagic);
        // dd($request->carta_magic);

        // $cartaMagic = auth()->user()->cartaMagics()->where('id', $request->carta_magic)->first();

        // O bien podria acerse sobre el Modelo PERO no obtendriamos relaccion con otras tablas
        // $cartaMagic = CartaMagic::where('id', $request->carta_magic)->first();

        // este nombre carta_magics.edit lo coje dir views
        return view( 'carta_magics.edit', compact('cartaMagic') );
    }

    /**
     * Update the specified resource in storage.
     * Usamos validaciones para datos recibidos
     * https://laravel.com/docs/9.x/validation#available-validation-rules
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartaMagic  $cartaMagic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartaMagic $cartaMagic)
    {
        // momento justo que usuario de a dado a submit y a llegado a servidor 
        // verficamos datos 
        $data = $request->validate([   // especificamos reglas de validacion para cada input
            // que no pueda estar repetida la carta para mismo user loged
            'titulo'=>Rule::unique('carta_magics')->where(function($query) use($cartaMagic){  // fx anonimas php
                // le diremos que el idenficador de usuario sea igual al de la carta.
                return $query->where('user_id', $cartaMagic->user->id);
            })->ignore($cartaMagic->id), // esta regla no se aplica para esta carta si no, no se podria editar con el mismo nombre
            'tipo'=>'required|string',
            'email_creador'=>'nullable|email',
            'imagen'=>'nullable|image',
            'description'=>'nullable|string',
        ]);
        if(isset( $request['imagen'] )){  //
            // https://laravel.com/api/9.x/Illuminate/Http/UploadedFile.html metodo guardar imagen recibida en servidor
            $imagen = $request['imagen']->store('images', 'public');  // public lo encontramos en ejemplos de codigo en doc 
            // https://image.intervention.io/v2/api/fit  editamo img con libreria
            Image::make(public_path("storage/$imagen"))->fit(800,800)->save();
            $data['imagen'] = $imagen;
            
            // dd( $imagen );
            // dd( $request );
        } 
        $cartaMagic->update($data);  // actualizamos la carta en bd

        // https://laravel.com/docs/8.x/helpers#method-redirect
        return redirect()->route('carta_magics.index');
        
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
