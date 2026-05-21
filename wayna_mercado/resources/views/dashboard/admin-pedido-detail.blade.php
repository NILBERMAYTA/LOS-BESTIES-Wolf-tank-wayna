{{-- resources/views/dashboard/admin-pedido-detail.blade.php --}}
@extends('layouts.app')

@section('title', 'Detalle Pedido')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Pedido #{{ $pedido->id_pedido }}</h2>
            <p class="text-muted mb-0">Detalle completo del pedido.</p>
        </div>
        <a href="{{ route('admin.pedidos') }}" class="btn btn-secondary">Volver a Pedidos</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <p><strong>Cliente:</strong> {{ $pedido->cliente->nombre ?? 'Cliente' }} {{ $pedido->cliente->apellido ?? '' }}</p>
            <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') }}</p>
            <p><strong>Estado:</strong> {{ ucfirst($pedido->estado_pedido) }}</p>
            <p><strong>Método pago:</strong> {{ $pedido->metodo_pago ?? '-' }}</p>
            <p><strong>Total:</strong> Bs. {{ number_format($pedido->total, 2) }}</p>

            <hr />
            <h5>Productos</h5>
            <ul class="list-group">
                @foreach($pedido->detalles as $detalle)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $detalle->producto->nombre_producto ?? 'Producto' }}</strong>
                            <div class="small text-muted">Unidad: Bs. {{ number_format($detalle->precio_unitario, 2) }}</div>
                        </div>
                        <span>x {{ $detalle->cantidad }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
