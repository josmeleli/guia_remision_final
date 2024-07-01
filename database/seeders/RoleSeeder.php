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
            'agricultor.index','agricultor.buscar',
            'campo.index', 'campo.buscar',
            'carga.index', 'carga.buscar',
            'conductores.index', 'conductores.buscar',
            'guia-remision.index',
            'verificar-ruc-agricultor', 'verificar-ruc-transportista',
            'pago.index', 'pago.buscar',
            'transportistas.index', 'transportistas.buscar',
            'vehiculo.index', 'vehiculo.buscar',
            'enviarMensaje.store', 'eliminarMensaje.destroy', 'eliminarTodosMensajes.destroy',

            
            
            
        ];


        $borrar_registrar_actualizar =[
            'transportistas.store', 'transportistas.update', 'transportistas.destroy', 'transportistas.borrar_seleccionados',
            'vehiculo.store', 'vehiculo.update', 'vehiculo.destroy', 'vehiculo.borrar_seleccionados',
            'agricultor.store', 'agricultor.update', 'agricultor.destroy','agricultor.borrar_seleccionados',
            'campo.store','campo.update','campo.destroy','campo.borrar_seleccionados',
            'carga.store', 'carga.update','carga.destroy','carga.borrar_seleccionados',
            'conductores.store','conductores.update','conductores.destroy','conductores.borrar_seleccionados',
            'guia_remision.store','guias.update','guias.destroy','guia_remision.borrar_seleccionados',
            'reporte.guias', 'crear_guia_remision',
            'pagos.store','pago.update','pago.destroy','pago.borrar_seleccionados',
            


            



            


        ];

        

        foreach ($buscar_mostrar as $permission) {
            Permission::create(['name' => $permission])->syncRoles([$role1, $role2, $role3]);


        }

        foreach ($borrar_registrar_actualizar as $permission) {
            Permission::create(['name' => $permission])->syncRoles([$role1, $role2]);


        }

        

        


        
        Permission::create(['name' => 'users.index'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.update'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.store'])->syncRoles([$role1]);
        Permission::create(['name' => 'users.destroy'])->syncRoles([$role1]);
        
    }
}