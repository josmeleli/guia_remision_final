<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\transportista;
use App\Models\agricultor;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\Chofer;
use App\Models\Carga;
use App\Models\campo;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class transportistaController extends Controller

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
        return view('transportista.index', compact('guias', 'pagos', 'campos', 'transportistas', 'agricultores', 'cargas', 'choferes'));
    }



    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'unidad_tecnica' => 'required',
                'campo' => 'nullable',
                'razon_social' => 'nullable',
                'codigo' => 'nullable',
                'zona' => 'nullable',
                'RUC' => [
                    'required',
                    'numeric',
                    'digits:11',
                    Rule::unique('transportistas')->where(function ($query) use ($request) {
                        return $query->where('RUC', $request->RUC);
                    }),
                ],

            ], [
                'RUC.unique' => 'El RUC ya está registrado.',
                'RUC.digits' => 'El RUC debe tener exactamente 11 dígitos.',
                'unidad_tecnica.required' => 'El campo Unidad Técnica es obligatorio.',
            ]);

            // Crear un nuevo objeto Transportista con los datos del formulario
            Transportista::create($validatedData);

            // Redireccionar a alguna vista después de guardar los datos
            return redirect()->route('mostrar.menu')->with('success', 'Transportista registrado exitosamente.');
        } catch (ValidationException $e) {
            // Capturar excepciones de validación y manejarlas
            return redirect()->back()->with('error', $e->validator->errors()->first());
        } catch (QueryException $e) {
            // Capturar excepciones de base de datos y manejarlas
            return redirect()->back()->with('error', 'Error al registrar el transportista: ' . $e->getMessage());
        }
    }





    public function update(Request $request, $id)
    {
        $transportista = transportista::findOrFail($id);
        $transportista->unidad_tecnica = $request->unidad_tecnica;
        $transportista->campo = $request->campo;
        $transportista->RUC = $request->RUC;
        $transportista->razon_social = $request->razon_social;
        $transportista->codigo = $request->codigo;
        $transportista->zona = $request->zona;


        // Guardar los cambios
        $transportista->save();

        // Redirigir de vuelta al formulario de edición con un mensaje de éxito
        return redirect()->back()->with('success', 'Trasportista actualizado correctamente');
    }

    public function destroy($id)
    {
        try {
            $transportista = transportista::findOrFail($id);
            $transportista->delete();

            return redirect()->back()->with('success', 'Transportista eliminado correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar transportista: ' . $e->getMessage());
        }
    }

    public function borrarSeleccionados(Request $request)
    {
        try {
            $transportistaIdsString = $request->input('transportista_ids');

            // Convertir la cadena de IDs en un array
            $transportistaIds = explode(',', $transportistaIdsString);

            // Verificar si se recibieron IDs de guías
            if (!empty($transportistaIds)) {
                // Borrar las guías de remisión seleccionadas
                transportista::whereIn('id', $transportistaIds)->delete();

                return redirect()->back()->with('success', 'Los transportistas  seleccionados se han borrado correctamente.');
            } else {
                return redirect()->back()->with('error', 'No se han seleccionado transportista para borrar.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar borrar los transportistas seleccionadas: ' . $e->getMessage());
        }
    }

    public function buscarTransportista(Request $request)
    {
        $transportistas = transportista::where('unidad_tecnica', 'like', '%' . $request->input('unidad_tecnica') . '%')
            ->Where('campo', 'like', '%' . $request->input('campo') . '%')
            ->Where('RUC', 'like', '%' . $request->input('RUC') . '%')
            ->Where('razon_social', 'like', '%' . $request->input('razon_social') . '%')
            ->Where('codigo', 'like', '%' . $request->input('codigo') . '%')
            ->Where('zona', 'like', '%' . $request->input('zona') . '%')

            ->get();

        return view('transportista.index', compact('transportistas'))->with('success', 'Busqueda exitosa');
    }
}
