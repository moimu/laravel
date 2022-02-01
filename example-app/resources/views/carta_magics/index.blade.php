@extends('layouts.app')


{{--   mostrar un <p> por cada parametro que le pasamos a la vista 
queremos mostrar los titulos de todas la cartas magics  --}}

@section('content')
<div class="container">

    {{-- uso bootstrap para dar formato a tabla --}}
    {{-- esta cargado en larabel --}}
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col"> Título </th>
                <th scope="col"> ... </th>
            </tr>
        </thead>

        <tbody>
            @foreach ($cartaMagics as $cartaMagic )
                <tr>
                    <td>{{ $cartaMagic->titulo }}</td>
                    <td><a href="{{route('carta_magics.edit', $cartaMagic->id )}}" role="button" class="btn btn-warning">Editar</a></td>
                    <td><a href="#" role="button" class="btn btn-danger">Borrar</a></td>
                <tr>
            @endforeach
        </tbody>

    </table>

</div>
@endsection