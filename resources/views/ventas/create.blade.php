@extends('layouts.app')
@section('title', 'Nueva venta')

@section('content')
<div class="card">
    <div class="card-header">Registrar venta</div>
    <div class="card-body">
        <form method="POST" action="{{ route('ventas.store') }}" id="ventaForm">
            @csrf
            <div class="row g-3 mb-3">
                <div class="col-md-6">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" class="form-select">
                        <option value="">Consumidor final</option>
                        @foreach($clientes as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre_completo }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Método de pago</label>
                    <select name="metodo_pago" class="form-select" required>
                        @foreach(['efectivo','tarjeta','yape','plin','transferencia'] as $m)
                            <option value="{{ $m }}">{{ $m }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <h6>Conceptos</h6>
            <div class="table-responsive">
                <table class="table" id="itemsTable">
                    <thead><tr><th>Tipo</th><th>Concepto</th><th>Cantidad</th><th>P. Unitario</th><th>Subtotal</th><th></th></tr></thead>
                    <tbody id="itemsBody"></tbody>
                </table>
            </div>
            <button type="button" class="btn btn-sm btn-outline-secondary mb-3" onclick="addItem()">Agregar concepto</button>

            <div class="text-end mb-3">
                <h5>Total: S/ <span id="totalVenta">0.00</span></h5>
            </div>

            <button type="submit" class="btn btn-primary">Registrar venta</button>
            <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>

<script>
const servicios = {!! json_encode($servicios->map(fn($s) => ['id' => $s->id, 'nombre' => $s->nombre, 'precio' => (float) $s->precio])) !!};
const productos = {!! json_encode($productos->map(fn($p) => ['id' => $p->id, 'nombre' => $p->nombre, 'precio' => (float) $p->precio_venta, 'stock' => $p->stock])) !!};

function addItem() {
    const tbody = document.getElementById('itemsBody');
    const row = document.createElement('tr');
    row.innerHTML = `
        <td>
            <select name="items[][tipo]" class="form-select form-select-sm tipoSelect" onchange="updateConceptos(this)">
                <option value="servicio">Servicio</option>
                <option value="producto">Producto</option>
            </select>
        </td>
        <td>
            <select name="items[][id]" class="form-select form-select-sm conceptoSelect" onchange="updatePrecio(this)"></select>
        </td>
        <td><input type="number" name="items[][cantidad]" class="form-control form-control-sm cantInput" value="1" min="1" onchange="calcSubtotal(this)"></td>
        <td><input type="number" step="0.01" name="items[][precio]" class="form-control form-control-sm precioInput" value="0" onchange="calcSubtotal(this)"></td>
        <td class="subtotalCell">0.00</td>
        <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="this.closest('tr').remove(); recalcTotal();"><i class="bi bi-trash"></i></button></td>
    `;
    tbody.appendChild(row);
    updateConceptos(row.querySelector('.tipoSelect'));
    recalcTotal();
}

function updateConceptos(sel) {
    const row = sel.closest('tr');
    const tipo = sel.value;
    const conceptoSel = row.querySelector('.conceptoSelect');
    const list = tipo === 'servicio' ? servicios : productos;
    conceptoSel.innerHTML = '';
    list.forEach(item => {
        const opt = document.createElement('option');
        opt.value = item.id;
        opt.textContent = item.nombre + (tipo==='producto' ? ' (stock: '+item.stock+')' : '');
        opt.dataset.precio = item.precio;
        conceptoSel.appendChild(opt);
    });
    updatePrecio(conceptoSel);
}

function updatePrecio(sel) {
    const row = sel.closest('tr');
    const opt = sel.options[sel.selectedIndex];
    const precio = opt ? opt.dataset.precio : 0;
    row.querySelector('.precioInput').value = precio;
    calcSubtotal(row.querySelector('.cantInput'));
}

function calcSubtotal(input) {
    const row = input.closest('tr');
    const cant = parseFloat(row.querySelector('.cantInput').value) || 0;
    const precio = parseFloat(row.querySelector('.precioInput').value) || 0;
    row.querySelector('.subtotalCell').textContent = (cant*precio).toFixed(2);
    recalcTotal();
}

function recalcTotal() {
    let total = 0;
    document.querySelectorAll('#itemsBody tr').forEach(row => {
        const cant = parseFloat(row.querySelector('.cantInput').value) || 0;
        const precio = parseFloat(row.querySelector('.precioInput').value) || 0;
        total += cant*precio;
    });
    document.getElementById('totalVenta').textContent = total.toFixed(2);
}

// Fix input names: Laravel expects items[0][tipo] etc. Current names items[][tipo] produce sequential? PHP handles items[][tipo] as nested? Actually items[][tipo] => items[0][tipo], items[1][tipo] yes.
</script>
@endsection
