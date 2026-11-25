<!DOCTYPE html><html><head><meta charset="utf-8"><title>Ventas</title>
<style>body{font-family:sans-serif;font-size:12px;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #ccc;padding:4px;} th{background:#eee;}</style>
</head><body>
<h2>Reporte de Ventas</h2>
<table><tr><th>ID</th><th>Fecha</th><th>Cliente</th><th>Total</th><th>Método</th><th>Estado</th></tr>
@foreach($ventas as $v)
<tr><td>{{ $v->id }}</td><td>{{ $v->fecha->format('d/m/Y') }}</td><td>{{ $v->cliente->nombre_completo ?? 'Consumidor final' }}</td><td>S/ {{ number_format($v->total,2) }}</td><td>{{ $v->metodo_pago }}</td><td>{{ $v->estado }}</td></tr>
@endforeach
</table></body></html>
