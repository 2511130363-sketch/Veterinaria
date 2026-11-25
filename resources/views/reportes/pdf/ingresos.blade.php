<!DOCTYPE html><html><head><meta charset="utf-8"><title>Ingresos</title>
<style>body{font-family:sans-serif;font-size:12px;} table{width:100%;border-collapse:collapse;} th,td{border:1px solid #ccc;padding:4px;} th{background:#eee;}</style>
</head><body>
<h2>Ingresos por fechas</h2>
<table><tr><th>Fecha</th><th>Ventas</th><th>Total</th></tr>
@foreach($ingresos as $i)
<tr><td>{{ $i->fecha }}</td><td>{{ $i->ventas }}</td><td>S/ {{ number_format($i->total,2) }}</td></tr>
@endforeach
<tr><td colspan="2"><strong>Total</strong></td><td><strong>S/ {{ number_format($totalGeneral,2) }}</strong></td></tr>
</table></body></html>
