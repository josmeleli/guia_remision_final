<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Guia de Remision</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-FZMNJ1bZHRJGox+2ZOI9bqzPCZfpePi8CnpORoHPhHOnlED1EqG74GZsXzGxVq58tzv4iymfAmJFZqtv7XKy4A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Tus estilos personalizados -->
    <style>
        /* Estilos para el header */
        header {
            
            /* Color de fondo del header */
            height: 60px;
            /* Altura del header */
            padding: 0 20px;
            /* Espaciado interno del header */
            display: flex;
            /* Utilizar flexbox */
            align-items: center;
            /* Alinear elementos verticalmente */
            justify-content: flex-end;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Sombra del header */
            
        }

        /* Estilos para el campo de búsqueda */
        .buscar input {
            flex: 1;
            /* El input ocupará todo el espacio disponible */
            padding: 8px 15px;
            /* Espaciado interno del input */
            border: 1px solid #ced4da;
            /* Borde del input */
            border-radius: 4px;
            /* Radio de borde del input */
            margin-right: 10px;
            /* Espaciado a la derecha del input */
        }

        /* Estilos para el botón de búsqueda */
        .buscar button {
            background-color: #007bff;
            /* Color de fondo del botón de búsqueda */
            color: #fff;
            /* Color del texto del botón de búsqueda */
            border: none;
            /* Quitar borde del botón de búsqueda */
            padding: 8px 15px;
            /* Espaciado interno del botón de búsqueda */
            border-radius: 4px;
            /* Radio de borde del botón de búsqueda */
            cursor: pointer;
            /* Cambiar cursor al pasar por encima del botón de búsqueda */
        }

        /* Estilos para los iconos en el header */
        .notify i,
        .user i {
            font-size: 24px;
            /* Tamaño de fuente de los iconos de notificación y usuario */
            margin-right: 10px;
            /* Espaciado a la derecha de los iconos de notificación y usuario */
            cursor: pointer;
            /* Cambiar cursor al pasar por encima de los iconos de notificación y usuario */
        }

        .user img {
            width: 30px;
            /* Ancho de la imagen de usuario */
            height: 30px;
            /* Altura de la imagen de usuario */
            border-radius: 50%;
            /* Hacer la imagen de usuario circular */
            margin-right: 10px;
            /* Espaciado a la derecha de la imagen de usuario */
        }
    </style>
</head>

<body>

    <header class="d-flex">
        
        
        <div class="notify" style="position: relative;">
            <i class="fas fa-bell"></i>
            <div id="notification-panel" class="card bg-light shadow" style="display: none; position: absolute; top: 30px; right: 0; width: 350px; z-index: 10000; max-height: 50vh; overflow-y: auto;">
                <div class="card-body">
                    
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-primary">Notificaciones:</h5>
                        <form action="{{ route('eliminarTodosMensajes.destroy') }}" method="POST" class="d-flex align-items-center justify-content-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Eliminar todo</button>
                        </form>
                    </div>
                    @foreach($messages as $message)
                        @if($message->receiver_id == auth()->user()->id)
                            @php
                                $sender = \App\Models\User::find($message->sender_id);
                            @endphp
                            <div class="card mb-3 shadow-sm">
                                <div class="card-header bg-primary d-flex justify-content-around align-items-center">
                                    <strong>De: {{ $sender ? $sender->email : 'Usuario desconocido' }}</strong> 
                                    <form method="POST"  action="{{ route('eliminarMensaje.destroy', $message->id) }}" class="d-flex align-items-center justify-content-center ml-auto" style="margin-bottom: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" style="padding: 0; border: none; background: none;">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                                <div class="card-body">
                                    <p class="card-text">{{ $message->message }}</p>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
            <i class="fas fa-envelope" id="envelope-icon"></i>

            <form id="email-form" method="POST" action="{{route('enviarMensaje.store') }}">
                @csrf
                <div id="email-panel" class="card" style="display: none; position: absolute; top: 30px; right: 0; width: 300px; z-index: 10000;">
                    <div class="card-body">
                    <h5 class="text-primary">Enviar Mensaje</h5>
                        <div class="form-group">
                            <label for="email-input">De:</label>
                            <input id="email-input" type="text" value="{{ auth()->user()->email }}" class="form-control" readonly>
                        </div>
                        <div class="form-group">
                            <label for="email-select">Para:</label>
                            <select id="email-select" name="email" class="form-control">
                                @foreach($users as $user)
                                <option value="{{ $user->email }}">{{ $user->email }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="message-text">Mensaje:</label>
                            <textarea id="message-text" name="message" class="form-control"></textarea>
                        </div>
                        <button id="send-message-button" type="submit" class="btn btn-primary">Enviar mensaje</button>
                    </div>
                </div>
            </form>
            <i class="fas fa-exclamation-circle"></i>
        </div>
        <div class="user" data-toggle="popover" data-placement="bottom" data-html="true" data-content='
                        <img class="user-image" src="https://img.freepik.com/vector-premium/joven-hombre-negocios-gafas-traje-negocios-corbata-icono-cara-avatar-estilo-plano_768258-3457.jpg" alt="Usuario"><br>
                        <span class="fas fa-user" > ROL ACTUAL</span>
                        <span class="pl-3">{{ Auth::user()->getRoleNames()->first() }}</span><br>


                        <span class="fas fa-user" > USUARIO</span>
                        <span class="pl-3" >{{ Auth::user()->name }}</span><br>

                        <span class="fas fa-envelope"> CORREO</span>
                        <span class="pl-3">{{ Auth::user()->email }}</span><br>
                        
                        <a  class="btn btn-danger" href={{ route("logout") }}" onclick="event.preventDefault(); document.getElementById("logout-form").submit();">Cerrar sesión</a>
                    '>
            <img src="https://img.freepik.com/vector-premium/joven-hombre-negocios-gafas-traje-negocios-corbata-icono-cara-avatar-estilo-plano_768258-3457.jpg" alt="Usuario">
        </div>

        <form id="logout-form" action="{{ route("logout") }}" method="POST" style="display: none;">
            @csrf
        </form>
    </header>

    
    <style>
        header {
            background-color: #f8f9fa;
            /* Color de fondo del header */
            height: 60px;
            /* Altura del header */
            padding: 0 20px;
            /* Espaciado interno del header */
            align-items: center;
            /* Alinear elementos verticalmente */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Sombra del header */
        }

        .amburgesa {
            margin-left: 2%;
        }

        .buscar {
            flex: 1;
            /* Ocupa el espacio restante */
            display: flex;
            /* Utilizar flexbox */
            align-items: center;
            /* Alinear elementos verticalmente */
        }

        .buscar input {
            width: 200px;
            /* Ancho del campo de búsqueda */
            padding: 8px;
            /* Espaciado interno del campo de búsqueda */
            border: 1px solid #ced4da;
            /* Borde del campo de búsqueda */
            border-radius: 4px;
            /* Radio de borde del campo de búsqueda */
            margin-right: 10px;
            /* Espaciado a la derecha del campo de búsqueda */
            margin-left: 20px
        }

        .buscar button {
            background-color: #007bff;
            /* Color de fondo del botón de búsqueda */
            color: #fff;
            /* Color del texto del botón de búsqueda */
            border: none;
            /* Quitar borde del botón de búsqueda */
            padding: 8px 15px;
            /* Espaciado interno del botón de búsqueda */
            border-radius: 4px;
            /* Radio de borde del botón de búsqueda */
            cursor: pointer;
            /* Cambiar cursor al pasar por encima del botón de búsqueda */
        }

        .notify,
        .user {
            display: flex;
            /* Utilizar flexbox */
            align-items: center;
            /* Alinear elementos verticalmente */
            margin-left: 20px;
            /* Espaciado a la izquierda de los elementos de notificación y usuario */
        }

        .notify i,
        .user i {
            font-size: 24px;
            /* Tamaño de fuente de los iconos de notificación y usuario */
            margin-right: 10px;
            /* Espaciado a la derecha de los iconos de notificación y usuario */
            cursor: pointer;
            /* Cambiar cursor al pasar por encima de los iconos de notificación y usuario */
        }

        .user img {
            width: 30px;
            /* Ancho de la imagen de usuario */
            height: 30px;
            /* Altura de la imagen de usuario */
            border-radius: 50%;
            /* Hacer la imagen de usuario circular */
            margin-right: 10px;
            /* Espaciado a la derecha de la imagen de usuario */
        }

        .popover-body {
            display: flex;
            /* Utilizar flexbox */
            align-items: flex-start;
            /* Alinear elementos al inicio verticalmente */
            justify-content: flex-start;
            /* Alinear elementos al inicio horizontalmente */
            flex-direction: column;
            /* Organizar los elementos en una columna */
            flex-wrap: wrap;
            /* Permitir que los elementos se envuelvan a la siguiente línea */
            position: relative;
            /* Necesario para posicionar correctamente el pseudo-elemento */
            border-radius: 30%;
        }

        .popover-body::before {
            content: "";
            /* Necesario para que el pseudo-elemento se muestre */
            position: absolute;
            /* Posicionar el pseudo-elemento absolutamente dentro de .popover-body */
            top: 0;
            /* Alinear el pseudo-elemento con la parte superior de .popover-body */
            left: 0;
            /* Alinear el pseudo-elemento con el lado izquierdo de .popover-body */
            width: 100%;
            /* El pseudo-elemento debe tener el mismo ancho que .popover-body */
            height: 30%;
            /* El pseudo-elemento debe tener el 30% de la altura de .popover-body */
            background: #00A0CE;
            /* Color de fondo del pseudo-elemento */
            z-index: -1;
            /* Asegurarse de que el pseudo-elemento esté detrás del contenido de .popover-body */
        }

        .user-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 10px;
            /* Espaciado debajo de la imagen de usuario */
            margin-top: 60px;
            /* Espaciado encima de la imagen de usuario */
        }


        .popover-body a {
            display: block;
            /* Cambiar a block */
            margin-left: auto;
            /* Margen automático a la izquierda */
            margin-right: auto;
            /* Margen automático a la derecha */
        }
    </style>

    @script('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script>
        $(document).ready(function() {
            $('[data-toggle="popover"]').popover();
            $(document).on('click', 'a[href="{{ route("logout") }}"]', function(e) {
                e.preventDefault();
                $('#logout-form').submit();
            });
        });

        $('#envelope-icon').on('click', function() {
            if ($('#email-panel').css('display') === 'none') {
                $('#email-panel').show();
            } else {
                $('#email-panel').hide();
            }
        });

        $('#send-message-button').on('click', function() {
            var email = $('#email-select').val();
            var message = $('#message-text').val();

            $.ajax({
                url: '/send-message',
                method: 'POST',
                data: {
                    email: email,
                    message: message,
                    _token: '{{ csrf_token() }}'
                },
                success: function() {
                    alert('Mensaje enviado!');
                    $('#email-panel').hide();
                }
            });
        });

        $(document).ready(function() {
            $('.fa-bell').click(function() {
                $('#notification-panel').toggle();
            });
        });
    </script>


</body>

</html>