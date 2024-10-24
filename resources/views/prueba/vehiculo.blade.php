@extends('adminlte::page')

@section('title', 'G3SEEKERSMX')

@section('content_header')
    <h1 class="text-center">
        <h1 class="text-center"><b>G3 Seekers México</b></h1>
    </h1>
    <br>

    <h1 class="text-center">Cliente :
        {{ $cliente->nombre }} {{ $cliente->segnombre }} {{ $cliente->apellidopat }} {{ $cliente->apellidomat }}
    </h1>

    <h1 class="text-center">Cuenta :
        @foreach ($cuenta as $cuent)
            {{ $cuent->usuario }}
        @endforeach
    </h1>
    <h3 class="text-center">Vehiculo('s')</h3>

    <br>

    @if (Session::has('mensaje'))
        <div class="alert alert-success alert dismissible" role="alert">
            {{ Session::get('mensaje') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <br>
    @can('vehiculo.create')
        <a href="{{ route('vehiculof.crear', $id) }}" class="btn btn-success">Registrar nuevo vehiculo</a>
    @endcan
<br>
    <br>
    <div class="card">
        <div class="card-body">

            <table class="table table-light">
                <thead class="thead-light">
                    <tr>
                        <th>Id del vehiculo</th>
                        <th>fecha de instalacion</th>

                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Color</th>
                        <th>Placa</th>
                        <th>Tipo de Unidad</th>
                        <th>Numero de Serie</th>
                        <th>Comentarios</th>
                        <th>Acciones</th>
                        <th></th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($vehiculos as $vehiculo)
                        <tr>
                            <td>{{ $vehiculo->id }}</td>
          {{--                 <td>{{ $vehiculo->Dispositivo->fechacompra }}</td>--}} 

                            <td>{{ $vehiculo->marca }} </td>
                            <td>{{ $vehiculo->modelo }}</td>
                            <td>{{ $vehiculo->color }} </td>
                            <td>{{ $vehiculo->placa }} </td>
                            <td> {{ $vehiculo->tipo }} </td>
                            <td>{{ $vehiculo->noserie }}</td>
                            <td> {{ $vehiculo->comentarios }} </td>
                            <td>
                                @can('vehiculo.edit')
                                    <a href="{{ url('/vehiculo/' . $vehiculo->id . '/edit') }}"
                                        class="btn btn-warning">Editar</a>
                                @endcan

                                @can('vehiculo.destroy')
                                    <form action="{{ url('/vehiculo/' . $vehiculo->id) }}" method="post" class="d-inline">
                                        @csrf
                                        {{ method_field('DELETE') }}
                                        <input class="btn btn-danger" type="submit"
                                            onclick=" return confirm('seguro quieres eliminar?')" value="Borrar">
                                    </form>
                                @endcan

                            </td>
                            <td>
                                <a href="{{ route('buscar.dispositivo', $vehiculo->id) }}"
                                    class="btn btn-primary">Dispositivo</a>
                            </td>
                    @endforeach
                </tbody>
            </table>


        </div>

    </div>
    {!! $vehiculos->links() !!}
    <br>
    <a href=" {{ route('buscar.cuenta', $cliente_id) }}" class="btn btn-dark">Regresar</a>


    </div>
@endsection
