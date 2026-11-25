<!DOCTYPE html><html><head><meta charset="utf-8"><title>Citas</title>
<style>body{font-family:sans-serif;font-size:12px;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #ccc;padding:4px;} th{background:#eee;}</style>
</head><body>
<h2>Reporte de Citas</h2>
<table><tr><th>ID</th><th>Fecha</th><th>Hora</th><th>Cliente</th><th>Mascota</th><th>Veterinario</th><th>Estado</th></tr>
@foreach($citas as $c)
<tr><td>{{ $c->id }}</td><td>{{ $c->fecha->format('d/m/Y') }}</td><td>{{ $c->hora }}</td><td>{{ $c->cliente->nombre_completo ?? '-' }}</td><td>{{ $c->mascota->nombre ?? '-' }}</td><td>{{ $c->veterinario->nombre_completo ?? '-' }}</td><td>{{ $c->estado }}</td></tr>
@endforeach
</table></body></html>
