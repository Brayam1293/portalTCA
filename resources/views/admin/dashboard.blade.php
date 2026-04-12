@extends('layouts.app')

<head>
    <title>Administrador</title>
    <style>
        body{
            font-family:Arial;
            padding:30px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th,td{
            border:1px solid #ddd;
            padding:10px;
            text-align:center;
        }

        button{
            padding:6px 12px;
            margin:2px;
            cursor:pointer;
        }

        input,select{
            padding:5px;
            width:90%;
        }

        .edit-row{
            display:none;
            background:#f8f8f8;
        }
    </style>
</head>

<body>
    <br><br><br><br><br>
    <h1>Panel Administrador</h1>

    <form method="GET" action="/admin">
        <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar usuario">
        <button type="submit">Buscar</button>

        <a href="/admin">
            <button type="button">Limpiar</button>
        </a>
    </form>

    <button onclick="crearUsuario()">Create User</button>
    <br><br>

    <table>
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Password</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>

        <tr id="createRow" style="display:none;">
            <td colspan="6">
                <form method="POST" action="/admin/create" style="display:flex; gap:10px; align-items:center;">
                    @csrf

                    <span>Nuevo</span>

                    <input type="email" name="usuario" placeholder="Correo" required>

                    <input type="text" name="password" placeholder="Password" required>

                    <select name="tipo_usuario">
                        <option value="1">Admin</option>
                        <option value="2" selected>Basico</option>
                    </select>

                    <select name="activo">
                        <option value="1" selected>Activo</option>
                        <option value="0">Desactivado</option>
                    </select>

                    <button type="submit">Guardar</button>
                    <button type="button" onclick="cancelarCrear()">Cancel</button>
                </form>
            </td>
        </tr>

        @foreach($usuarios as $u)
        <tr id="view{{ $u->id }}" class="fila-usuario">
            <td>{{ $u->id }}</td>
            <td>{{ $u->usuario }}</td>
            <td>{{ $u->password }}</td>
            <td>{{ $u->tipo_usuario == 1 ? 'Admin' : 'Basico' }}</td>
            <td>
                @if($u->activo == 1)
                    Activo
                @else
                    Desactivado
                @endif
            </td>

            <td>
                <button onclick="editar({{ $u->id }})">Edit</button>

                <form method="POST" action="/admin/delete/{{ $u->id }}" style="display:inline;">
                @csrf
                <button type="submit">Delete</button>
                </form>

                <a href="/admin/user/{{ $u->id }}">
                <button type="button">View</button>
                </a>
            </td>
        </tr>

        <tr id="edit{{ $u->id }}" class="edit-row">
            <form method="POST" action="/admin/update/{{ $u->id }}">
                @csrf

                <td>{{ $u->id }}</td>
                <td>
                    <input type="text" name="usuario" value="{{ $u->usuario }}">
                </td>
                <td>
                    <input type="text" name="password" value="{{ $u->password }}">
                </td>
                <td>
                    <select name="tipo_usuario">
                        <option value="1" {{ $u->tipo_usuario==1?'selected':'' }}>Admin</option>
                        <option value="2" {{ $u->tipo_usuario==2?'selected':'' }}>Basico</option>
                    </select>
                </td>
                <td>
                    @if($u->activo == 1)
                    <span style="color:green;font-weight:bold;">Activo</span>
                    @else
                    <span style="color:red;font-weight:bold;">Desactivado</span>
                    @endif
                </td>

                <td>
                    <button type="submit">Save</button>
                    <button type="button" onclick="cancelar({{ $u->id }})">Cancel</button>
                </td>
            </form>
        </tr>
        @endforeach
    </table>

    <div style="margin-top:20px; text-align:center;">
        @php
            $buscar = request('buscar');
        @endphp

        @if ($usuarios->onFirstPage())
            <button disabled>Anterior</button>
        @else
            <a href="{{ url('/admin?page=' . ($usuarios->currentPage() - 1) . '&buscar=' . urlencode($buscar)) }}">
                <button>Anterior</button>
            </a>
        @endif

        <span style="margin:0 15px;">
            Página {{ $usuarios->currentPage() }} de {{ $usuarios->lastPage() }}
        </span>

        @if ($usuarios->hasMorePages())
            <a href="{{ url('/admin?page=' . ($usuarios->currentPage() + 1) . '&buscar=' . urlencode($buscar)) }}">
                <button>Siguiente</button>
            </a>
        @else
            <button disabled>Siguiente</button>
        @endif
    </div>
</body>