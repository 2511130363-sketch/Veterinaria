<!DOCTYPE html><html><head><meta charset="utf-8"><title>Consultas</title>
<style>body{font-family:sans-serif;font-size:12px;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #ccc;padding:4px;} th{background:#eee;}</style>
</head><body>
<h2>Reporte de Consultas</h2>
<table><tr><th>ID</th><th>Fecha</th><th>Mascota</th><th>Propietario</th><th>Veterinario</th><th>Diagnóstico</th></tr>
@foreach($consultas as $c)
<tr><td>{{ $c->id }}</td><td>{{ $c->fecha->format('d/m/Y') }}</td><td>{{ $c->mascota->nombre ?? '-' }}</td><td>{{ $c->mascota->cliente->nombre_completo ?? '-' }}</td><td>{{ $c->veterinario->nombre_completo ?? '-' }}</td><td>{{ $c->diagnostico }}</td></tr>
@endforeach
</table></body></html>
