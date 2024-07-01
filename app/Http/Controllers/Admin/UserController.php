<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Message;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.users.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario registrado correctamente');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Primero, removemos todos los roles del usuario
        $user->roles()->detach();

        // Luego, asignamos los nuevos roles
        if ($request->roles) {
            $user->roles()->attach($request->roles);
        }

        // Redirigimos al usuario con un mensaje de éxito
        return redirect()->route('users.index', $user)->with('success', 'Roles asignados con éxito');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente');
    }



    public function enviarMensaje(Request $request)
    {
        $receiver = User::where('email', $request->email)->first();

        if ($receiver) {
            $message = new Message;
            $message->sender_id = auth()->user()->id;
            $message->receiver_id = $receiver->id;
            $message->message = $request->message;
            $message->save();
        }

        return redirect()->route('mostrar.menu')->with('success', 'Mensaje enviado correctamente');
    }

    public function mostrarNotificaciones()
    {
        $messages = Message::all();
        return view('notifications', ['messages' => $messages]);
    }

    public function eliminarMensaje($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        return redirect()->back()->with('success', 'Mensaje eliminado correctamente');
    }

    public function eliminarTodosMensajes()
    {
        // Obtén el ID del usuario actual
        $userId = auth()->id();

        // Encuentra todos los mensajes del usuario actual y elimínalos
        Message::where('receiver_id', $userId)->delete();

        // Redirige al usuario a la página anterior con un mensaje de éxito
        return back()->with('success', 'Todos los mensajes han sido eliminados.');
    }
}
