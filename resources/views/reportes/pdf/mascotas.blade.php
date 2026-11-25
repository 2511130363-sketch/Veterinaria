<!DOCTYPE html><html><head><meta charset="utf-8"><title>Mascotas</title>
<style>body{font-family:sans-serif;font-size:12px;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #ccc;padding:4px;} th{background:#eee;}</style>
</head><body>
<h2>Reporte de Mascotas</h2>
<table><tr><th>ID</th><th>Nombre</th><th>Especie</th><th>Raza</th><th>Sexo</th><th>Propietario</th></tr>
@foreach($mascotas as $m)
<tr><td>{{ $m->id }}</td><td>{{ $m->nombre }}</td><td>{{ $m->especie }}</td><td>{{ $m->raza }}</td><td>{{ $m->sexo }}</td><td>{{ $m->cliente->nombre_completo ?? '-' }}</td></tr>
@endforeach
</table></body></html>
