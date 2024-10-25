<?php

namespace App\Http\Controllers;

use App\Models\Dispositivo;
use App\Models\Vehiculo;
use App\Models\Cliente;
use Illuminate\Http\Request;

class DispositivoController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $dispositivos = Dispositivo::where(function ($query) use ($busqueda) {
            $query->where('id', 'LIKE', "%{$busqueda}%")
                  ->orWhere('imei', 'LIKE', "%{$busqueda}%")
                  ->orWhere('cuenta', $busqueda)
                  ->orWhere('noeconomico', 'LIKE', "%{$busqueda}%");
        })->paginate(10);

        return view('dispositivo.index', compact('dispositivos', 'busqueda'));
    }

    public function creardisp($id)
    {
        return view('dispositivo.createid', compact('id'));
    }

    public function stodis(Request $request, $id)
    {
        $vehiculo = Vehiculo::findOrFail($id);
        
        $request->validate($this->validationRules($id));

        $datosCliente = array_merge($request->except('_token'), [
            'cliente_id' => $vehiculo->cliente_id,
            'vehiculo_id' => $id
        ]);

        Dispositivo::create(array_map('strtoupper', $datosCliente));

        return redirect()->route('buscar.dispositivo', $id);
    }

    public function edit($id)
    {
        $dispositivo = Dispositivo::findOrFail($id);
        $vehiculos = Vehiculo::all();
        $clientes = Cliente::all();

        return view('dispositivo.edit', compact('dispositivo', 'clientes', 'vehiculos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate($this->validationRules($id));

        $datosDispositivo = $request->except(['_token', '_method']);
        Dispositivo::where('id', $id)->update($datosDispositivo);

        return redirect()->route('buscar.dispositivo', Dispositivo::findOrFail($id)->vehiculo_id);
    }

    public function destroy($id)
    {
        Dispositivo::destroy($id);
        return redirect()->back()->with('mensaje', 'Dispositivo eliminado exitosamente.');
    }

    public function create()
    {
        $vehiculos = Vehiculo::all();
        $clientes = Cliente::all();

        return view('dispositivo.create', compact('vehiculos', 'clientes'));
    }

    public function store(Request $request)
    {
        $request->validate($this->validationRules());

        Dispositivo::create($request->except('_token'));

        return redirect()->route('dispositivo.index')->with('mensaje', 'Dispositivo agregado exitosamente.');
    }

    private function validationRules($id = null)
    {
        return [
            'modelo' => 'required|alpha_dash|min:2|max:100',
            'noserie' => 'nullable|alpha_dash|min:20|unique:dispositivos,noserie' . ($id ? ",$id" : ''),
            'imei' => 'required|numeric|min:18|unique:dispositivos,imei' . ($id ? ",$id" : ''),
        ];
    }
}
