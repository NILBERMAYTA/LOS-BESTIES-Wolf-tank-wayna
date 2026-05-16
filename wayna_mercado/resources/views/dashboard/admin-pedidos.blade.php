{{-- resources/views/dashboard/admin-pedidos.blade.php --}}
@extends('layouts.app')

@section('title', 'Pedidos Admin')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Pedidos</h2>
            <p class="text-muted mb-0">Lista de compras realizadas por clientes.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al panel</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            @if($pedidos->count())
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Fecha</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Productos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->id_pedido }}</td>
                                    <td>{{ $pedido->cliente->nombre ?? 'Cliente' }} {{ $pedido->cliente->apellido ?? '' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') }}</td>
                                    <td>Bs. {{ number_format($pedido->total, 2) }}</td>
                                    <td>{{ ucfirst($pedido->estado_pedido) }}</td>
                                    <td>
                                        @foreach($pedido->detalles as $detalle)
                                            <div>
                                                <strong>{{ $detalle->producto->nombre_producto ?? 'Producto' }}</strong>
                                                x {{ $detalle->cantidad }}
                                            </div>
                                        @endforeach
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $pedidos->links() }}
                </div>
            @else
                <div class="alert alert-info mb-0">
                    No hay pedidos registrados todavía.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
