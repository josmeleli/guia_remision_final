<?php

namespace App\Http\Controllers;
use Illuminate\Database\QueryException;

use App\Models\campo;
use Illuminate\Http\Request;
use App\Models\Guia;
use App\Models\Pago;
use App\Models\transportista;
use App\Models\agricultor;
use App\Models\User;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Illuminate\Support\Facades\DB;

class guiaController extends Controller
{
    public function index()
    {
        $totalGuias = Guia::count();
        $guiasPorEstado = [
            'Guía Facturada' => Guia::where('estado', 'guia_facturada')->count(),
            'Guía por Facturar' => Guia::where('estado', 'guia_por_facturar')->count(),
            'Factura Cancelada' => Guia::where('estado', 'factura_cancelada')->count(),
            'Factura por Cancelar' => Guia::where('estado', 'factura_por_cancelar')->count(),
        ];

        
        $guiasHoy = Guia::whereDate('fecha_emision', today())->count();

        $guiasPorEstadoConDetalles = [];

        foreach ($guiasPorEstado as $estado => $cantidad) {
            $guias = Guia::where('estado', $estado)->get();
            $guiasPorEstadoConDetalles[$estado] = $guias;
        }
        
        
       
        $guias = Guia::all();
        $pagos = Pago::all();
        $campos = campo::all();
        $agricultores = Agricultor::all();
        $agricultor = Agricultor::first();
        $agricultorId = $agricultor ? $agricultor->id : null;

        $transportista = Transportista::first();
        $transportistaId = $transportista ? $transportista->id : null;
        $transportistas = transportista::all();
        return view('guia_remision.index', compact('guias','pagos','campos','transportistas','agricultorId','transportistaId','agricultores','totalGuias','guiasPorEstado','guiasHoy','guiasPorEstadoConDetalles'));
    }
    
    

    public function store(Request $request)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'fecha_emision' => 'required|date',
                'nro_guia' => 'required|unique:guias,nro_guia',
                'nro_ticket' => 'required',
                'fecha_partida' => 'required|date',
                'punto_partida' => 'required',
                'punto_llegada' => 'required',
                'producto' => 'required',
                'peso_bruto' => 'required',
                'estado' => 'required',
                'ruc_agricultor' => 'required',
                'ruc_transportista' => 'required',
            ]);

            // Obtener el ID del agricultor y del transportista
            $agricultorId = Agricultor::where('ruc', $request->ruc_agricultor)->value('id');
            $transportistaId = Transportista::where('RUC', $request->ruc_transportista)->value('id');
        
            // Verificar si se encontraron los IDs
            if (!$agricultorId || !$transportistaId) {
                return redirect()->back()->with('error', 'No se encontró un agricultor o transportista con el RUC proporcionado.');
            }
        
            // Asignar los IDs encontrados
            $validatedData['agricultor_id'] = $agricultorId;
            $validatedData['transportista_id'] = $transportistaId;

            // Crear una nueva instancia de GuiaRemision con los datos del formulario
            Guia::create($validatedData);

            // Redireccionar al usuario a la página deseada después de guardar la guía de remisión
            return redirect()->back()->with('success', '¡La guía de remisión se ha creado exitosamente!');
        } catch (QueryException $e) {
            // Capturar excepciones de base de datos y manejarlas
            return redirect()->back()->with('error', 'Error al guardar la guía de remisión: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Capturar otras excepciones y manejarlas
            return redirect()->back()->with('error', 'Error desconocido al guardar la guía de remisión: ' . $e->getMessage());
        }
    }
    public function edit($id)
    {
        
    }

    
    public function update(Request $request, $id)
    {
        try {
            // Validar los datos del formulario
            $validatedData = $request->validate([
                'fecha_emision' => 'required|date',
                'nro_guia' => 'required|unique:guias,nro_guia,'.$id,
                'nro_ticket' => 'required',
                'fecha_partida' => 'required|date',
                'punto_partida' => 'required',
                'punto_llegada' => 'required',
                'producto' => 'required',
                'peso_bruto' => 'required',
                'estado' => 'required',
                'ruc_agricultor' => 'required',
                'ruc_transportista' => 'required',
            ]);

            // Obtener el ID del agricultor y del transportista
            $agricultorId = Agricultor::where('ruc', $request->ruc_agricultor)->value('id');
            $transportistaId = Transportista::where('RUC', $request->ruc_transportista)->value('id');

            // Verificar si se encontraron los IDs
            if (!$agricultorId || !$transportistaId) {
                return redirect()->back()->with('error', 'No se encontró un agricultor o transportista con el RUC proporcionado.');
            }

            // Asignar los IDs encontrados
            $validatedData['agricultor_id'] = $agricultorId;
            $validatedData['transportista_id'] = $transportistaId;

            // Buscar la guía de remisión por su ID
            $guia = Guia::findOrFail($id);

            // Actualizar los datos de la guía de remisión
            $guia->update($validatedData);

            // Redireccionar al usuario a la página deseada después de actualizar la guía de remisión
            return redirect()->back()->with('success', '¡La guía de remisión se ha actualizado exitosamente!');
        } catch (QueryException $e) {
            // Capturar excepciones de base de datos y manejarlas
            return redirect()->back()->with('error', 'Error al actualizar la guía de remisión: ' . $e->getMessage());
        } catch (\Exception $e) {
            // Capturar otras excepciones y manejarlas
            return redirect()->back()->with('error', 'Error desconocido al actualizar la guía de remisión: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $guia = Guia::findOrFail($id);
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
            $guiaIdsString = $request->input('guia_ids');
            
            // Convertir la cadena de IDs en un array
            $guiaIds = explode(',', $guiaIdsString);
    
            // Verificar si se recibieron IDs de guías
            if (!empty($guiaIds)) {
                // Borrar las guías de remisión seleccionadas
                Guia::whereIn('id', $guiaIds)->delete();
    
                return redirect()->back()->with('success', 'Las guías de remisión seleccionadas se han borrado correctamente.');
            } else {
                return redirect()->back()->with('error', 'No se han seleccionado guías de remisión para borrar.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar borrar las guías de remisión seleccionadas: ' . $e->getMessage());
        }
    }

    public function verificarRuc(Request $request)
    {
        $ruc = $request->input('ruc_agricultor');

        $datos = agricultor::where('ruc', $ruc)->first();
        if ($datos) {
            return response()->json([
                'razon_social' => $datos->razon_social,
                'direccion' => $datos->direccion,
            ]);
        } else {
            return response()->json(['error' => 'No se encontraron datos para el RUC proporcionado'], 404);
        }
        
    }

    public function verificarRucTransportista(Request $request)
    {
        $ruc = $request->input('ruc_transportista');

        $datos = transportista::where('ruc', $ruc)->first();
        if ($datos) {
            return response()->json([
                'razon_social' => $datos->razon_social,
                'zona' => $datos->zona,
            ]);
        } else {
            return response()->json(['error' => 'No se encontraron datos para el RUC proporcionado'], 404);
        }
        
    }

    
    // public function buscarPorRUC(Request $request)
    //     {
    //         $ruc = $request->ruc;
    //         // Realiza la búsqueda en la base de datos por el RUC proporcionado
    //         $transportista = Transportista::where('ruc', $ruc)->first();

    //         if ($transportista) {
    //             return response()->json(['success' => true, 'transportista_id' => $transportista->id]);
    //         } else {
    //             return response()->json(['success' => false, 'error' => 'No se encontró ningún transportista con el RUC proporcionado.']);
    //         }
    //     }
    
    
    
    
    public function reporteGuias() 
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Establecer los nombres de las columnas en la primera fila
        $sheet->setCellValue('A1', 'ID');
        $sheet->setCellValue('B1', 'Fecha de Emisión');
        $sheet->setCellValue('C1', 'Numero de Guía');
        $sheet->setCellValue('D1', 'Numero de Ticket');
        $sheet->setCellValue('E1', 'Fecha de Partida');
        $sheet->setCellValue('F1', 'Punto de Partida');
        $sheet->setCellValue('G1', 'Punto de Llegada');
        $sheet->setCellValue('H1', 'Producto');
        $sheet->setCellValue('I1', 'Peso Bruto');
        $sheet->setCellValue('J1', 'Estado');


        // Aplica un estilo de fondo azul a las celdas A1, B1, C1
        $sheet->getStyle('A1:J1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('00A0CE');

        $guias = Guia::all();
        $row = 2; // Comenzar desde la segunda fila porque la primera fila se usa para los nombres de las columnas
        foreach ($guias as $guia) {
            
            $sheet->setCellValue('A' . $row, $guia->id);  
            $sheet->setCellValue('B' . $row, $guia->fecha_emision);
            $sheet->setCellValue('C' . $row, $guia->nro_guia);
            $sheet->setCellValue('D' . $row, $guia->nro_ticket);
            $sheet->setCellValue('E' . $row, $guia->fecha_partida);
            $sheet->setCellValue('F' . $row, $guia->punto_partida);
            $sheet->setCellValue('G' . $row, $guia->punto_llegada);
            $sheet->setCellValue('H' . $row, $guia->producto);
            $sheet->setCellValue('I' . $row, $guia->peso_bruto);
            $sheet->setCellValue('J' . $row, $guia->estado);    
           
            
            $row++;
        }

        // Ajustar el ancho de las columnas al contenido
        foreach (range('A', $sheet->getHighestDataColumn()) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'guias-de-remision.xlsx';
        $writer->save($filename);

        return response()->download($filename)->deleteFileAfterSend(true);
    }
    
    
    
}
