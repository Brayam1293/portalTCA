@extends('layouts.app')

<br><br><br><br><br>
<h1>Usuario: {{ $usuario->usuario }}</h1>

<p>ID: {{ $usuario->id }}</p>
<p>Tipo: {{ $usuario->tipo_usuario }}</p>
<p>Verificado: {{ $usuario->is_verified }}</p>

<h2>Temas creados</h2>

<table border="1" width="100%">
    <tr>
        <th>ID</th>
        <th>Titulo</th>
        <th>Categoria</th>
        <th>Mensaje</th>
        <th>Visible</th>
    </tr>

    @foreach($temas as $t)
    <tr>
        <td>{{ $t->id_foro }}</td>
        <td>{{ $t->titulo }}</td>
        <td>{{ $t->categoria }}</td>
        <td>{{ $t->mensaje }}</td>
        <td>{{ $t->visible ? 'SI' : 'NO' }}</td>
    </tr>
    @endforeach
</table>

<a href="/admin">Volver</a>