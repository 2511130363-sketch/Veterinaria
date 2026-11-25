<!DOCTYPE html><html><head><meta charset="utf-8"><title>Servicios</title>
<style>body{font-family:sans-serif;font-size:12px;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #ccc;padding:4px;} th{background:#eee;}</style>
</head><body>
<h2>Servicios más solicitados</h2>
<table><tr><th>Servicio</th><th>Cantidad</th><th>Monto</th></tr>
@foreach($servicios as $s)
<tr><td>{{ $s->servicio->nombre ?? '-' }}</td><td>{{ $s->total }}</td><td>S/ {{ number_format($s->monto,2) }}</td></tr>
@endforeach
</table></body></html>
