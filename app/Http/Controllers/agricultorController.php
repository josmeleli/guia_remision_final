<?php

namespace App\Http\Controllers;
use App\Models\agricultor;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\Chofer;
use App\Models\Carga;
use App\Models\Transportista;
use App\Models\campo;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class agricultorController extends Controller
{
    public function index()
    {
        $guias = Guia::all();
        $choferes = Chofer::all();
        $cargas = Carga::all();
        $pagos = Pago::all();
        $agricultores = Agricultor::all();
        $campos = campo::all();
        $transportistas = transportista::all();
        return view('agricultor.index', compact('guias','pagos','campos','transportistas','agricultores','cargas','choferes'));
    }
    

    
    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'dni' => [
                    'required',
                    Rule::unique('agricultors')->where(function ($query) use ($request) {
                        return $query->where('dni', $request->dni);
                    }),
                ],
                'apellidos' => 'required',
                'nombres' => 'required',
                'ruc' => 'numeric|required|unique:agricultors,ruc',
                'razon_social' => 'required',
                'direccion' => 'required',
            ], [
                'dni.unique' => 'El DNI ya está registrado.', // Mensaje personalizado para la regla unique
                'ruc.unique' => 'El RUC ya está registrado.', // Mensaje personalizado para la regla unique
            ]);

            // Crear una nueva instancia de agricultor con los datos validados y guardarla en la base de datos
            Agricultor::create($validatedData);

            // Redireccionar de vuelta a la página del formulario con un mensaje de éxito
            return redirect()->route('mostrar.menu')->with('success', 'Agricultor registrado exitosamente.');
        } catch (ValidationException $e) {
            // Capturar excepciones de validación y manejarlas
            return redirect()->back()->with('error', $e->validator->errors()->first());
        } catch (\Exception $e) {
            // Capturar excepciones de base de datos y manejarlas
            return redirect()->back()->with('error', 'Error al registrar el agricultor: ' . $e->getMessage());
        }
    }
    
   
    public function update(Request $request, $id)
    {
        try {
            // Encontrar el agricultor por su ID
            $agricultor = Agricultor::findOrFail($id);
    
            // Actualizar los campos del agricultor con los datos del formulario
            $agricultor->nombres = $request->nombres;
            $agricultor->apellidos = $request->apellidos;
            $agricultor->dni = $request->dni;
            $agricultor->ruc = $request->ruc;
            $agricultor->razon_social = $request->razon_social;
            $agricultor->direccion = $request->direccion;
            // Actualiza los demás campos aquí...
    
            // Guardar los cambios
            $agricultor->save();
    
            // Redirigir de vuelta al formulario de edición con un mensaje de éxito
            return redirect()->back()->with('success', 'Agricultor actualizado correctamente');
        } catch (\Exception $e) {
            // Manejar excepciones si ocurre algún error
            return redirect()->back()->with('error', 'Error al actualizar el agricultor: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $agricultor = agricultor::findOrFail($id);
            $agricultor->delete();
            
            return redirect()->back()->with('success', 'Agricultor eliminado correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar agricultor: ' . $e->getMessage());
        }
    }

    
    public function borrarSeleccionados(Request $request)
    {
        try {
            $agricultorIdsString = $request->input('agricultor_ids');
            
            // Convertir la cadena de IDs en un array
            $agricultorIds = explode(',', $agricultorIdsString);

            // Verificar si se recibieron IDs de agricultores
            if (!empty($agricultorIds)) {
                // Borrar los agricultores seleccionados
                Agricultor::whereIn('id', $agricultorIds)->delete();

                return redirect()->back()->with('success', 'Los agricultores seleccionados se han borrado correctamente.');
            } else {
                return redirect()->back()->with('error', 'No se han seleccionado agricultores para borrar.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar borrar los agricultores seleccionados: ' . $e->getMessage());
        }
    }

    public function buscarAgricultor(Request $request){
        $agricultores = Agricultor::where('nombres', 'like', '%'.$request->input('nombres').'%')
        ->where('apellidos', 'like', '%'.$request->input('apellidos').'%')
        ->where('dni', 'like', '%'.$request->input('dni').'%')
        ->where('ruc', 'like', '%'.$request->input('ruc').'%')
        ->where('razon_social', 'like', '%'.$request->input('razon_social').'%')
        ->where('direccion', 'like', '%'.$request->input('direccion').'%')
        
        
        ->get();


        return view('agricultor.index', compact('agricultores'));

    }
    
}
