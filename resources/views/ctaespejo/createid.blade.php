@extends('adminlte::page')

@section('title', 'G3SEEKERSMX')

@section('content_header')
    <h1 class="text-center"><b>G3 Seekers México</b></h1>
    <br>
    <h3 class="text-center">Datos Personales</h3>
    <br>

    crear cta espejo

    <form action=" {{ route('ctaespejop.crear', $id) }} " method="post">
        @csrf



        <div class="form-group">
            <label>Usuario:</label>
            <input type="text" class="form-control" name="usuario" value=" {{ old('usuario') }} ">
        </div>
        @error('usuario')
            <small style ="color: red"> {{ $message }}</small>
        @enderror
        <br>

        <div class="form-group">
            <label> Contraseña : </label>
            <input type="text" class="form-control" name="contrasenia" value=" {{ old('contrasenia') }} ">
        </div>
        @error('contrasenia')
            <small style ="color: red"> {{ $message }}</small>
        @enderror
        <br>

        <div class="form-group">
            <label> Comentarios:</label>
            <input type="text" class="form-control" name="comentarios" value=" {{ old('comentarios') }} ">
        </div>
        @error('comentarios')
            <small style ="color: red"> {{ $message }}</small>
        @enderror
        <br>


        <div class="form-group">
            <input type="submit" class="btn btn-success" value="Enviar Datos">
    </form>
    </div>
@endsection
