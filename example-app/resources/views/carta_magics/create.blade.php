@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Crear nueva carta Magic</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('carta_magics.store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="titulo" class="col-md-4 col-form-label text-md-end">
                                Título
                            </label>
 
                            <div class="col-md-6">
                                <input 
                                    type="text" 
                                    class="form-control @error('titulo') is-invalid @enderror" 
                                    name="titulo" 
                                    value="{{ old('titulo') }}" 
                                    required 
                                    autocomplete="titulo" 
                                    autofocus
                                >

                                @error('titulo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-8 offset-md-4">

                                <button type="submit" class="btn btn-primary">
                                    Crear carta
                                </button>

                            </div>
                        </div>

                    </form>
                </div>

                

            </div>
        </div>
    </div>
</div>
@endsection
