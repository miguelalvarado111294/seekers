<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuenta;

class CuentaController extends Controller
{
    public function index(Request $request)
    {
        $busqueda = $request->get('busqueda');
        $cuentas = Cuenta::where('usuario', 'LIKE', '%' . $busqueda . '%')->paginate(10);
        return view('cuenta.index', compact('cuentas', 'busqueda'));
    }

    public function crearcta($id)
    {
        return view('cuenta.createid', compact('id'));
    }

    public function crearc($id)
    {
        return view('registroCliente.datoscuenta', compact('id'));
    }

    public function createnuevocta(Request $request, $id)
    {
        $this->validateRequest($request, $id);
        $datosCliente = $this->prepareData($request, $id);
        Cuenta::create($datosCliente);
        return redirect()->route('buscar.cuenta', $id);
    }

    public function stocta(Request $request, $id)
    {
        $this->validateRequest($request, $id);
        $datosCliente = $this->prepareData($request, $id);
        Cuenta::create($datosCliente);
        return redirect()->route('buscar.cuenta', $id);
    }

    public function store(Request $request, $id)
    {
        $this->validateRequest($request, $id);
        $datosCuenta = $request->except('_token');
        Cuenta::create($datosCuenta);
        return redirect('cuenta')->with('mensaje', 'Cuenta agregada exitosamente.');
    }

    public function show(Cuenta $cuenta) {}

    public function edit($id)
    {
        $cuenta = Cuenta::findOrFail($id);
        return view('cuenta.edit', compact('cuenta'));
    }

    public function update(Request $request, $id)
    {
        $this->validateUpdateRequest($request);
        Cuenta::where('id', $id)->update($request->except(['_token', '_method']));
        return redirect()->route('buscar.cuenta', $id);
    }

    public function destroy($id)
    {
        Cuenta::destroy($id);
        return redirect()->back()->with('mensaje', 'Cuenta eliminada exitosamente.');
    }

    public function create()
    {
        return view('cuenta.create');
    }

    private function validateRequest(Request $request, $id)
    {
        $request->validate([
            'usuario' => 'required|alpha_dash|min:3|max:15|unique:cuentas,usuario,' . $id,
            'contrasenia' => 'required|alpha_dash|min:2|max:15',
            'contraseniaParo' => 'required|alpha_dash|min:2|max:100',
            'comentarios' => 'nullable|alpha|min:10|max:100'
        ]);
    }

    private function validateUpdateRequest(Request $request)
    {
        $request->validate([
            'usuario' => 'required|alpha_dash|min:3|max:15',
            'contrasenia' => 'required|alpha_dash|min:2|max:15',
            'contraseniaParo' => 'required|alpha_dash|min:2|max:100',
            'comentarios' => 'nullable|alpha|min:10|max:100'
        ]);
    }

    private function prepareData(Request $request, $clienteId)
    {
        $datosCliente = $request->except('_token');
        $datosCliente['cliente_id'] = $clienteId;
        return array_map('strtoupper', $datosCliente);
    }
}
