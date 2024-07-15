<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'administrador']);
        $role2 = Role::create(['name' => 'asistente']);
        $role3 = Role::create(['name' => 'cliente']);

        $buscar_mostrar = [
            'mostrar.menu',
            'agricultor.index', 'agricultor.buscar',
            'campo.index', 'campo.buscar',
            'carga.index', 'carga.buscar',
            'conductores.index', 'conductores.buscar',
            'guia-remision.index',
            'verificar-ruc-agricultor', 'verificar-ruc-transportista',
            'pago.index', 'pago.buscar',
            'transportista.index', 'transportista.buscar',
            'vehiculo.index', 'vehiculo.buscar',
            'enviarMensaje.store', 'eliminarMensaje.destroy', 'eliminarTodosMensajes.destroy',




        ];


        $borrar_registrar_actualizar = [
            'transportista.store', 'transportista.update', 'transportista.destroy', 'transportista.borrar_seleccionados',
            'vehiculo.store', 'vehiculo.update', 'vehiculo.destroy', 'vehiculo.borrar_seleccionados',
            'agricultor.store', 'agricultor.update', 'agricultor.destroy', 'agricultor.borrar_seleccionados',
            'campo.store', 'campo.update', 'campo.destroy', 'campo.borrar_seleccionados',
            'carga.store', 'carga.update', 'carga.destroy', 'carga.borrar_seleccionados',
            'conductores.store', 'conductores.update', 'conductores.destroy', 'conductores.borrar_seleccionados',
            'guia_remision.store', 'guias.update', 'guias.destroy', 'guia_remision.borrar_seleccionados',
            'reporte.guias', 'crear_guia_remision',
            'pagos.store', 'pago.update', 'pago.destroy', 'pago.borrar_seleccionados',
            'guia-remision.mostrar',

        ];

        $todos_permisos = [
            'auditorias.index', 'auditorias.destroy', 'auditorias.borrar_seleccionados', 'auditorias.buscar',
            'users.index', 'users.edit', 'users.update', 'users.store', 'users.destroy',
        ];



        foreach ($buscar_mostrar as $permission) {
            Permission::create(['name' => $permission])->syncRoles([$role1, $role2, $role3]);
        }

        foreach ($borrar_registrar_actualizar as $permission) {
            Permission::create(['name' => $permission])->syncRoles([$role1, $role2]);
        }

        foreach ($todos_permisos as $permission) {
            Permission::create(['name' => $permission])->syncRoles([$role1]);
        }
    }
}
