<div>

    <div class="card">
        <div class="card-header">
            <input  wire:model="search" class="form-control" placeholder="Ingrese el nombre o correo del usuario">
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Acciones</th>
                    </tr>

                </thead>

                <tbody>
                    @foreach ($users->reverse() as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td >
                                <a   class="btn btn-primary" href="{{ route('users.edit', $user) }}">Editar</a>
                                <form style="display: inline-block;" action="{{ route('users.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger" type="submit">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
</div>