<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pago;
use App\Models\Guia;
use App\Models\campo;
use App\Models\transportista;
use App\Models\vehiculo;
use App\Models\Agricultor;

class pagoController extends Controller
{
    public function index()
    {
        $guias = Guia::all();
        $pagos = Pago::all();
        $agricultores = Agricultor::all();
        $campos = campo::all();
        $transportistas = transportista::all();
        return view('pago.index', compact('guias', 'pagos', 'campos', 'transportistas', 'agricultores'));
    }
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'agricultor_id' => 'required|exists:agricultors,id', // El agricultor debe existir en la tabla 'agricultors'
            'precio_unitario' => 'required|numeric',
            'adelanto' => 'required|numeric',
            'tipo_pago' => 'required|string',
            'num_pago' => 'required|string',
        ]);

        // Crear un nuevo pago
        Pago::create([
            'agricultor_id' => $request->agricultor_id,
            'precio_unitario' => $request->precio_unitario,
            'adelanto' => $request->adelanto,
            'tipo_pago' => $request->tipo_pago,
            'num_pago' => $request->num_pago,
        ]);

        // Redireccionar a una ruta después de guardar el pago (opcional)
        return redirect()->back()->with('success', '¡El pago ha sido registrado correctamente!');
    }

    public function borrarSeleccionados(Request $request)
    {
        try {
            $pagoIdsString = $request->input('pago_ids');

            // Convertir la cadena de IDs en un array
            $pagoIds = explode(',', $pagoIdsString);

            // Verificar si se recibieron IDs de guías
            if (!empty($pagoIds)) {
                // Borrar las guías de remisión seleccionadas
                Pago::whereIn('id', $pagoIds)->delete();

                return redirect()->back()->with('success', 'Los pagos  seleccionados se han borrado correctamente.');
            } else {
                return redirect()->back()->with('error', 'No se han seleccionado pagos para borrar.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar borrar los pagos seleccionadas: ' . $e->getMessage());
        }
    }



    public function update(Request $request, $id)
    {
        // Validar los datos del formulario
        $request->validate([
            'agricultor_id' => 'required|exists:agricultors,id',
            'precio_unitario' => 'required|numeric',
            'adelanto' => 'required|numeric',
            'tipo_pago' => 'required|in:Efectivo,Tarjeta de Débito,Transferencia Bancaria',
            'num_pago' => 'required|string',
            // Agrega aquí más validaciones si es necesario
        ]);

        // Buscar el pago a actualizar
        $pago = Pago::findOrFail($id);

        // Actualizar los campos del pago
        $pago->agricultor_id = $request->agricultor_id;
        $pago->precio_unitario = $request->precio_unitario;
        $pago->adelanto = $request->adelanto;
        $pago->tipo_pago = $request->tipo_pago;
        $pago->num_pago = $request->num_pago;
        // Actualiza otros campos si es necesario

        // Guardar los cambios
        $pago->save();

        // Redireccionar a una ruta después de actualizar el pago (opcional)
        return redirect()->back()->with('success', '¡El pago ha sido actualizado correctamente!');
    }
    public function destroy($id)
    {
        try {
            $guia = Pago::findOrFail($id);
            $guia->delete();

            return redirect()->back()->with('success', 'Pago eliminado correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al pago: ' . $e->getMessage());
        }
    }

    public function buscarPago(Request $request)
    {
        $agricultores = Agricultor::all();
        $pagos = Pago::Where('precio_unitario', 'like', '%' . $request->input('precio_unitario') . '%')
            ->Where('adelanto', 'like', '%' . $request->input('adelanto') . '%')
            ->Where('num_pago', 'like', '%' . $request->input('num_pago') . '%')
            ->Where('tipo_pago', 'like', '%' . $request->input('tipo_pago') . '%')
            ->whereHas('agricultor', function ($query) use ($request) {
                $query->where('nombres', 'like', '%' . $request->input('agricultor_id') . '%');
            })

            ->get();

        return view('pago.index', compact('pagos', 'agricultores'));
    }
}
