<?php

namespace App\Http\Controllers;
use App\Models\Chofer;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\transportista;
use App\Models\agricultor;
use App\Models\Carga;
use App\Models\campo;
use App\Models\vehiculo;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class choferController extends Controller
{
    public function index()
    {
        $guias = Guia::all();
        $choferes = Chofer::all();
        $cargas = Carga::all();
        $vehiculos = vehiculo::all();
        $pagos = Pago::all();
        $agricultores = Agricultor::all();
        $campos = campo::all();
        $transportistas = transportista::all();
        return view('conductor.index', compact('guias','pagos','campos','transportistas','agricultores','cargas','choferes','vehiculos'));
    }
    
    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'dni' => [
                    'required',
                    'numeric',
                    Rule::unique('chofers')->where(function ($query) use ($request) {
                        return $query->where('dni', $request->dni);
                    }),
                ],
                'brevete' => 'nullable|unique:chofers,brevete', 
                'nombre_apellidos' => 'required',
                'telefono' => 'required|numeric|digits:9|unique:chofers,telefono',
                
            ], [
                'dni.unique' => 'El DNI ya está registrado.', // Mensaje personalizado para la regla unique
                'telefono.unique' => 'El teléfono ya está registrado.', // Mensaje personalizado para la regla unique
                'brevete.unique' => 'El brevete ya está registrado.', // Mensaje personalizado para la regla unique

            ]);

            // Crear una nueva instancia de conductor con los datos validados y guardarla en la base de datos
            Chofer::create($validatedData);

            
            

            // Redireccionar de vuelta a la página del formulario con un mensaje de éxito
            return redirect()->route('mostrar.menu')->with('success', 'Conductor registrado exitosamente.');
        } catch (ValidationException $e) {
            // Capturar excepciones de validación y manejarlas
            return redirect()->back()->with('error', $e->validator->errors()->first());
        }catch (\Exception $e) {
            // Capturar excepciones de base de datos y manejarlas
            return redirect()->back()->with('error', 'Error al registrar el conductor: ' . $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        $chofer = Chofer::findOrFail($id);
        $chofer->brevete = $request->brevete;
        $chofer->dni = $request->dni;
        $chofer->nombre_apellidos = $request->nombre_apellidos;
        $chofer->telefono = $request->telefono;

        // Guardar los cambios
        $chofer->save();

        // Actualizar la fila en la tabla 'chofer_vehiculos'
        

        // Redirigir de vuelta al formulario de edición con un mensaje de éxito
        return redirect()->back()->with('success', 'Conductor actualizado correctamente');
    }

    public function destroy($id)
    {
        try {
            $guia = Chofer::findOrFail($id);

            // Desasocia todos los vehiculos del chofer en la tabla intermedia
            $guia->vehiculos()->detach();

            $guia->delete();
            
            return redirect()->back()->with('success', 'Guía de remisión eliminada correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar la guía de remisión: ' . $e->getMessage());
        }
    }

    public function borrarSeleccionados(Request $request)
    {
        try {
            $choferIdsString = $request->input('chofer_ids');
            
            // Convertir la cadena de IDs en un array
            $choferIds = explode(',', $choferIdsString);

            // Verificar si se recibieron IDs de choferes
            if (!empty($choferIds)) {
                // Borrar los choferes seleccionados
                Chofer::whereIn('id', $choferIds)->delete();

                return redirect()->back()->with('success', 'Los choferes seleccionados se han borrado correctamente.');
            } else {
                return redirect()->back()->with('error', 'No se han seleccionado choferes para borrar.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar borrar los choferes seleccionados: ' . $e->getMessage());
        }
    }

    public function buscarConductor(Request $request)
    {
        $choferes = Chofer::where('dni', 'like', '%' . $request->input('dni') . '%')
            ->where('nombre_apellidos', 'like', '%' . $request->input('nombre_apellidos') . '%')
            ->where('telefono', 'like', '%' . $request->input('telefono') . '%')
            ->get();

        return view('conductor.index', compact('choferes'));
    }
}
