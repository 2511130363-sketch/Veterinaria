<!DOCTYPE html>
<html><head><meta charset="utf-8"><title>Clientes</title>
<style>body{font-family:sans-serif;font-size:12px;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #ccc;padding:4px;} th{background:#eee;}</style>
</head><body>
<h2>Reporte de Clientes</h2>
<table>
<tr><th>ID</th><th>Nombre</th><th>DNI</th><th>Teléfono</th><th>Email</th><th>Mascotas</th></tr>
@foreach($clientes as $c)
<tr>
<td>{{ $c->id }}</td><td>{{ $c->nombre_completo }}</td><td>{{ $c->dni }}</td><td>{{ $c->telefono }}</td><td>{{ $c->email }}</td><td>{{ $c->mascotas_count }}</td>
</tr>
@endforeach
</table>
</body></html>
