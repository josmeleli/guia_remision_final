<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Carga;
use App\Models\Chofer;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\agricultor;
use App\Models\campo;
use App\Models\transportista;
use Illuminate\Support\Facades\DB;

class cargaController extends Controller
{

    public function index()
    {
        $guias = Guia::all();
        $choferes = Chofer::all();
        $cargas = Carga::all()->map(function ($carga) {
            $carga->chofer = DB::table('chofers')
                ->where('id', $carga->chofer_id)
                ->first();
            return $carga;
        });
        $pagos = Pago::all();
        $agricultores = Agricultor::all();
        $campos = campo::all();
        $transportistas = transportista::all();
        return view('carga.index', compact('guias','pagos','campos','transportistas','agricultores','cargas','choferes'));
    }
    

   

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validatedData = $request->validate([
            'chofer_id' => 'required|exists:chofers,id',
            'total_carga_bruta' => 'required',
            'total_carga_neta' => 'required',
            'total_material_extrano' => 'required',
            'tara' => 'required',
            'nro_ticket' => 'required',
            'km_origen' => 'required',
            'km_de_destino' => 'required',
            'fecha_carga' => 'required|date',
            'fecha_de_descarga' => 'required|date',
        ]);

        // Crear una nueva instancia de carga con los datos validados y guardarla en la base de datos
        Carga::create($validatedData);

        // Redireccionar de vuelta a la página del formulario con un mensaje de éxito
        return redirect()->route('mostrar.menu')->with('success', 'Carga registrada exitosamente.');
    }

    public function update(Request $request, $id)
    {
        $carga = Carga::findOrFail($id);
        $carga->chofer_id = $request->chofer_id;
        $carga->total_carga_bruta = $request->total_carga_bruta;
        $carga->total_carga_neta = $request->total_carga_neta;
        $carga->total_material_extrano = $request->total_material_extrano;
        $carga->tara = $request->tara;
        $carga->nro_ticket = $request->nro_ticket;
        $carga->km_origen = $request->km_origen;
        $carga->km_de_destino = $request->km_de_destino;
        $carga->fecha_carga = $request->fecha_carga;
        $carga->fecha_de_descarga = $request->fecha_de_descarga;
       

        // Guardar los cambios
        $carga->save();

        // Redirigir de vuelta al formulario de edición con un mensaje de éxito
        return redirect()->back()->with('success', 'Carga actualizada correctamente');
    }

    public function destroy($id)
    {
        try {
            $carga = Carga::findOrFail($id);
            $carga->delete();
            
            return redirect()->back()->with('success', 'Carga eliminada correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar carga: ' . $e->getMessage());
        }
    }

    public function borrarSeleccionados(Request $request)
    {
        try {
            $cargaIdsString = $request->input('carga_ids');
            
            // Convertir la cadena de IDs en un array
            $cargaIds = explode(',', $cargaIdsString);

            // Verificar si se recibieron IDs de cargas
            if (!empty($cargaIds)) {
                // Borrar las cargas seleccionadas
                Carga::whereIn('id', $cargaIds)->delete();

                return redirect()->back()->with('success', 'Las cargas seleccionadas se han borrado correctamente.');
            } else {
                return redirect()->back()->with('error', 'No se han seleccionado cargas para borrar.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar borrar las cargas seleccionadas: ' . $e->getMessage());
        }
    }

    public function buscarCarga(Request $request)
    {

        $choferes = Chofer::all();
        $cargas = Carga::where('total_carga_bruta', 'like', '%' . $request->input('total_carga_bruta') . '%')
            ->where('total_carga_neta', 'like', '%' . $request->input('total_carga_neta') . '%')
            ->where('total_material_extrano', 'like', '%' . $request->input('total_material_extrano') . '%')
            ->where('tara', 'like', '%' . $request->input('tara') . '%')
            ->where('nro_ticket', 'like', '%' . $request->input('nro_ticket') . '%')
            ->where('km_origen', 'like', '%' . $request->input('km_origen') . '%')
            ->where('km_de_destino', 'like', '%' . $request->input('km_de_destino') . '%')
            ->where('fecha_carga', 'like', '%' . $request->input('fecha_carga') . '%')
            ->where('fecha_de_descarga', 'like', '%' . $request->input('fecha_de_descarga') . '%')

            ->whereHas('chofer', function ($query) use ($request) {
                $query->where('dni', 'like', '%' . $request->input('chofer_id') . '%');
            })

            
            ->get();

        return view('carga.index', compact('cargas', 'choferes'));

    }

}
