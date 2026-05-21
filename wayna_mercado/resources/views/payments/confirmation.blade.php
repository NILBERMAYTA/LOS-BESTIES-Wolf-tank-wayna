@extends('layouts.app')

@section('title', 'Confirmación de Pago')

@section('content')
<div class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header" style="background: var(--wayna-orange); color: white;">
            <h4 class="mb-0">Confirmación de {{ $type === 'compra' ? 'Compra' : 'Donación' }}</h4>
        </div>
        <div class="card-body">
            @if($type === 'compra')
                <div class="mb-4">
                    <p class="mb-1">Tu compra se ha procesado correctamente.</p>
                    <p class="small text-muted">Detalle del pedido #{{ $pedido->id_pedido }}</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-3">
                        <strong>Pedido</strong>
                        <p>#{{ $pedido->id_pedido }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Fecha</strong>
                        <p>{{ \Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Total</strong>
                        <p>Bs. {{ number_format($pedido->total, 2) }}</p>
                    </div>
                    <div class="col-md-3">
                        <strong>Método</strong>
                        <p>{{ $pedido->metodo_pago ?? 'No especificado' }}</p>
                    </div>
                </div>

                <div class="table-responsive mb-4">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio unitario</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->producto->nombre_producto ?? 'Producto' }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td>Bs. {{ number_format($detalle->precio_unitario, 2) }}</td>
                                    <td>Bs. {{ number_format($detalle->subtotal, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <strong>Comisión Wayna</strong>
                        <p>Bs. {{ number_format($pedido->comision_plataforma, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Total emprendedor</strong>
                        <p>Bs. {{ number_format($pedido->total_emprendedor, 2) }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Estado</strong>
                        <p>{{ ucfirst($pedido->estado_pedido) }}</p>
                    </div>
                </div>
            @else
                <div class="mb-4">
                    <p class="mb-1">Tu donación se ha registrado correctamente.</p>
                    <p class="small text-muted">Detalle de la donación #{{ $donacion->id_donacion }}</p>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <strong>Cliente</strong>
                        <p>{{ $donacion->cliente->nombre ?? 'Cliente' }} {{ $donacion->cliente->apellido ?? '' }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Emprendedor</strong>
                        <p>{{ $donacion->emprendedor->nombre_emprendimiento ?? 'Emprendedor' }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Monto</strong>
                        <p>Bs. {{ number_format($donacion->monto, 2) }}</p>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-4">
                        <strong>Fecha</strong>
                        <p>{{ \Carbon\Carbon::parse($donacion->fecha_donacion)->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>Estado</strong>
                        <p>{{ ucfirst($donacion->estado) }}</p>
                    </div>
                    <div class="col-md-4">
                        <strong>ID donación</strong>
                        <p>{{ $donacion->id_donacion }}</p>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Mensaje de apoyo</strong>
                    <p>{{ $donacion->mensaje_apoyo ?? 'Sin mensaje adicional' }}</p>
                </div>
            @endif

            <div class="d-flex gap-2">
                <a href="{{ route('dashboard') }}" class="btn btn-wayna">Ir al dashboard</a>
                <a href="{{ route('productos.index') }}" class="btn btn-secondary">Seguir viendo productos</a>
            </div>
        </div>
    </div>
</div>
@endsection
