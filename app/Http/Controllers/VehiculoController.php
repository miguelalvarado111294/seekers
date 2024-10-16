<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\vehiculo;
use App\Models\cliente;
use App\Models\cuenta;
use App\Models\dispositivo;

class VehiculoController extends Controller
{

    public function index(Request $request)
    {

        $busqueda = $request->get('busqueda');  //recibe del input de index cliente y lo almacena en una variable 
        
        $vehiculos = Vehiculo::where('noserie', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('nomotor', 'LIKE', '%' . $busqueda . '%')
            ->orWhere('placa', 'LIKE', '%' . $busqueda . '%') ->paginate(10);

        return view('vehiculo.index', compact('vehiculos','busqueda'));
    }

    public function create()
    {
        $clientes = Cliente::all();
        $dispositivo = Dispositivo::all();
        $cuentas = Cuenta::all();
        return view('vehiculo.create', compact('clientes', 'tipounidad', 'cuentas', 'dispositivo'));
    }


    public function crearvehi($id)
    {
        $cuentas = cuenta::all();
        return view('vehiculo.createid', compact('id', 'cuentas'));
    }


    //crear desde cliente
    public function crearvehiculo ($id)
    {
       // $cuentas = cuenta::all();
        return view('registroCliente.datosvehiculo', compact('id'));
    }

    public function createvehiculo(Request $request, $id)
    {
        return $request;
        $request->validate([
            'marca' => 'required|alpha_dash|min:3|max:100',
            'modelo' => 'required|alpha_num|alpha_dash',
            'noserie' => 'required|alpha_dash|min:5|unique:vehiculos,noserie,' . $id,
            'nomotor' => 'required|alpha_dash|min:5|unique:vehiculos,nomotor,' . $id,
            'placa' => 'required|alpha_dash|min:4|unique:vehiculos,placa,' . $id,
            'color' => 'string|min:4|max:15'
        ]);

        $datosCliente = $request->except('_token');
        $datosCliente['cliente_id'] = $id;
        $mArray = array_map('strtoupper', $datosCliente);
        Vehiculo::insert($mArray);

        return redirect()->route('buscar.vehiculo', $id);
    }

    public function stovehi(Request $request, $id)
    {
        $request->validate([
            'marca' => 'required|alpha_dash|min:3|max:100',
            'modelo' => 'required|alpha_num|alpha_dash',
            'noserie' => 'required|alpha_dash|min:5|unique:vehiculos,noserie,' . $id,
            'nomotor' => 'required|alpha_dash|min:5|unique:vehiculos,nomotor,' . $id,
            'placa' => 'required|alpha_dash|min:4|unique:vehiculos,placa,' . $id,
            'color' => 'string|min:4|max:15'
        ]);

        $datosCliente = $request->except('_token');
        $datosCliente['cliente_id'] = $id;
        $mArray = array_map('strtoupper', $datosCliente);
        Vehiculo::insert($mArray);

        return redirect()->route('buscar.vehiculo', $id);
    }

    public function store(Request $request,$id)
    {

        $campos = [
            'marca' => 'required|alpha_dash|min:3|max:100',
            'modelo' => 'required|alpha_num|alpha_dash',
            'noserie' => 'required|alpha_dash|min:5|unique:vehiculos,noserie,' . $id,
            'nomotor' => 'required|alpha_dash|min:5|unique:vehiculos,nomotor,' . $id,
            'placa' => 'required|alpha_dash|min:4|unique:vehiculos,placa,' . $id,
            'color' => 'string|min:4|max:15'
        ];

        $this->validate($request, $campos/*$mensaje*/);
        $datosVehiculo = $request->except('_token');
        Vehiculo::insert($datosVehiculo);
        return redirect('vehiculo')->with('mensaje', 'vehiculo agregado exitosamente ');
    }

    public function edit($id)
    {

        $clientes = Cliente::all();
        $vehiculo = Vehiculo::findOrfail($id);
        return view('vehiculo.edit', compact('vehiculo'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'marca' => 'required|alpha_dash|min:3|max:100',
            'modelo' => 'required|alpha_num|alpha_dash',
            'noserie' => 'required|alpha_dash|min:5|unique:vehiculos,noserie,' . $id,
            'nomotor' => 'required|alpha_dash|min:5|unique:vehiculos,nomotor,' . $id,
            'placa' => 'required|alpha_dash|min:4|unique:vehiculos,placa,' . $id,
            'color' => 'string|min:4|max:15'
        ]);

        $vehiculo = Vehiculo::where('id', '=', $id)->update($request->except(['_token', '_method']));
        $vehiculo = Vehiculo::find($id);
        return redirect()->route('buscar.vehiculo', $vehiculo->cliente_id);
    }

    public function destroy($id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        Vehiculo::destroy($id);
        return redirect()->route('buscar.vehiculo', $vehiculo->cliente_id);
    }
}
