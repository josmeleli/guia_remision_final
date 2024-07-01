<?php

namespace App\Http\Controllers;

use App\Models\agricultor;
use Illuminate\Http\Request;
use App\Models\vehiculo;
use App\Models\Transportista;
use App\Models\chofer;
use App\Models\Carga;
use App\Models\Pago;
use App\Models\campo;
use App\Models\Guia;
use App\Models\User;

class vehiculoController extends Controller
{
    public function index()
    {
        $guias = Guia::all();
        $choferes = Chofer::all();
        $vehiculos = vehiculo::all();
        $cargas = Carga::all();
        $pagos = Pago::all();
        $agricultores = Agricultor::all();
        $campos = campo::all();
        $transportistas = transportista::all();
        $user = User::first();
        $message = '¡Hola! ' . $user->name;
        return view('vehiculos.index', compact('guias','pagos','campos','transportistas','agricultores','cargas','choferes','vehiculos','message'));
    }

    public function mostrarMenu()
    {
        $transportistas = Transportista::all();
        $agricultores = Agricultor::all();
        $cargas = Carga::all();
        $vehiculos = vehiculo::all();
        $pagos = Pago::all();
        $campos = campo::all();
        $conductores = chofer::all(); // Obtener todos los conductores

        $user = User::first();
        $message = '¡Hola! ' . $user->name;

        $agricultor = Agricultor::first();
        $agricultorId = $agricultor ? $agricultor->id : null;

        $transportista = Transportista::first();
        $transportistaId = $transportista ? $transportista->id : null;
        
        
        return view('menu', compact('transportistas', 'conductores', 'agricultores', 'cargas', 'vehiculos', 'pagos', 'campos', 'message', 'agricultorId', 'transportistaId'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dueño' => 'required',
            'placa' => 'required',
            'placa1' => 'required',
            'codigo' => 'required',
            'num_ejes' => 'required',
            'id_transportista' => 'required'

        ]);

        $datos = new vehiculo();

        $datos-> dueño = $request-> dueño;
        $datos-> placa = $request-> placa;
        $datos-> placa1 = $request-> placa1;
        $datos-> codigo = $request-> codigo;
        $datos-> num_ejes = $request-> num_ejes;
        $datos->id_transportista = $request->id_transportista;

        $datos->save();

        return redirect()->route('mostrar.menu')->with('success', 'Vehiculo guardado correctamente');
        
    }

    public function update(Request $request, $id)
    {
        $vehiculo = vehiculo::findOrFail($id);
        $vehiculo->dueño = $request->dueño;
        $vehiculo->placa = $request->placa;
        $vehiculo->placa1 = $request->placa1;
        $vehiculo->codigo = $request->codigo;
        $vehiculo->num_ejes = $request->num_ejes;
        $vehiculo->id_transportista = $request->id_transportista;
       
       

        // Guardar los cambios
        $vehiculo->save();

        // Redirigir de vuelta al formulario de edición con un mensaje de éxito
        return redirect()->back()->with('success', 'Vehiculo actualizado correctamente');
    }

    public function destroy($id)
    {
        try {
            $vehiculo = vehiculo::findOrFail($id);
            $vehiculo->delete();
            
            return redirect()->back()->with('success', 'Vehiculo eliminado correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar Vehiculo: ' . $e->getMessage());
        }
    }


    public function borrarSeleccionados(Request $request)
    {
        try {
            $vehiculoIdsString = $request->input('vehiculo_ids');
            
            // Convertir la cadena de IDs en un array
            $vehiculoIds = explode(',', $vehiculoIdsString);

            // Verificar si se recibieron IDs de vehiculos
            if (!empty($vehiculoIds)) {
                // Borrar los vehiculos seleccionados
                Vehiculo::whereIn('id', $vehiculoIds)->delete();

                return redirect()->back()->with('success', 'Los vehiculos seleccionados se han borrado correctamente.');
            } else {
                return redirect()->back()->with('error', 'No se han seleccionado vehiculos para borrar.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar borrar los vehiculos seleccionados: ' . $e->getMessage());
        }
    }
    
    public function buscarVehiculo(Request $request)
    {
        $vehiculos = vehiculo::where('placa', 'like', '%' . $request->input('placa') . '%')
        ->where('placa1', 'like', '%' . $request->input('placa1') . '%')
        ->where('codigo', 'like', '%' . $request->input('codigo') . '%')
        ->where('num_ejes', 'like', '%' . $request->input('num_ejes') . '%')
        ->where('dueño', 'like', '%' . $request->input('dueño') . '%')
        ->where('id_transportista', 'like', '%' . $request->input('id_transportista') . '%')
        
            
            ->get();

        return view('vehiculos.index', compact('vehiculos'));
    }
    
    
}
