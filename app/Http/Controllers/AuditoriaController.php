<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use App\Models\Auditoria;
use OwenIt\Auditing\Contracts\Audit;
use App\Models\User;

class AuditoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $auditorias = Auditoria::all();
        $usuarios = User::whereIn('id', $auditorias->pluck('user_id'))->get();
        $usuariosMapeo = $usuarios->pluck('name', 'id')->toArray();

        $rolesMapeo = $usuarios->mapWithKeys(function ($user) {
            return [$user->id => $user->roles->pluck('name')->join(', ')];
        })->toArray();

        return view('auditorias.index', compact('auditorias', 'usuariosMapeo', 'rolesMapeo'));
    }
    
    
    

    public function destroy($id)
    {
        try {
            $auditorias = Auditoria::findOrFail($id);
            $auditorias->delete();
            
            return redirect()->back()->with('success', 'Auditoria eliminado correctamente');
        } catch (\Exception $e) {
            // Manejo de errores si la guía no se encuentra o hay otros problemas
            return redirect()->back()->with('error', 'Error al eliminar auditoria: ' . $e->getMessage());
        }
    }

    
    public function borrarSeleccionados(Request $request)
    {
        try {
            $auditoriaIdsString = $request->input('auditoria_ids');
            
            // Convertir la cadena de IDs en un array
            $auditoriaIds = explode(',', $auditoriaIdsString);

            // Verificar si se recibieron IDs de agricultores
            if (!empty($auditoriaIds)) {
                // Borrar los agricultores seleccionados
                Auditoria::whereIn('id', $auditoriaIds)->delete();

                return redirect()->back()->with('success', 'Las auditorias seleccionadas se han borrado correctamente.');
            } else {
                return redirect()->back()->with('error', 'No se han seleccionado auditorias para borrar.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Ocurrió un error al intentar borrar las auditorias seleccionadas: ' . $e->getMessage());
        }
    }

    public function buscarAuditoria(Request $request)
{
    $auditorias = Auditoria::where('auditable_type', 'like', '%' . $request->input('tabla') . '%')
        ->where('event', 'like', '%' . $request->input('evento') . '%')
        ->where('created_at', 'like', '%' . $request->input('fecha') . '%')
        ->get();

    $usuarios = User::whereIn('id', $auditorias->pluck('user_id'))->get();
    $usuariosMapeo = $usuarios->pluck('name', 'id')->toArray();

    $rolesMapeo = $usuarios->mapWithKeys(function ($user) {
        return [$user->id => $user->roles->pluck('name')->join(', ')];
    })->toArray();

    return view('auditorias.index', compact('auditorias', 'usuariosMapeo', 'rolesMapeo'));
}

}
