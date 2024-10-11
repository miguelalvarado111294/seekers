@extends('adminlte::page')

@section('title', 'G3SEEKERSMX')

@section('content_header')
<h1 class="text-center"><b>G3 Seekers México</b></h1>
<br>
    <h3 class="text-center">Editar Vehiculo</h3>
<br>
<div class="card">

    <div class="card-body">
        <form action="{{ url('/vehiculo/' . $vehiculo->id) }}" method="post" enctype="multipart/form-data">
            @csrf
            {{ method_field('PATCH') }}
            @include('/vehiculo.form', ['modo' => 'Editar'])
        </form>


    </div>
</div>
<a href="{{ URL::previous() }}" class="btn btn-dark">Regresar</a>

        
@endsection
