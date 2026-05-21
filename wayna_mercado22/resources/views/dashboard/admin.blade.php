{{-- resources/views/dashboard/admin.blade.php --}}
@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <form class="row gy-2 gx-3 align-items-end" method="GET" action="{{ route('admin.dashboard') }}">
                        <div class="col-auto">
                            <label class="form-label">Inicio</label>
                            <input type="date" name="start_date" class="form-control" value="{{ $startDateString ?? now()->startOfMonth()->format('Y-m-d') }}">
                        </div>
                        <div class="col-auto">
                            <label class="form-label">Fin</label>
                            <input type="date" name="end_date" class="form-control" value="{{ $endDateString ?? now()->format('Y-m-d') }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-wayna">Filtrar</button>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.dashboard.export', array_merge(['format' => 'csv'], request()->only(['start_date','end_date']))) }}" class="btn btn-outline-secondary">Exportar CSV</a>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('admin.dashboard.export', array_merge(['format' => 'xls'], request()->only(['start_date','end_date']))) }}" class="btn btn-outline-secondary">Exportar XLS</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row g-4">
        <div class="col-md-3">
            <div class="card shadow-sm p-4 text-center">
                <h5>Usuarios registrados</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalUsuarios }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-4 text-center">
                <h5>Emprendedores</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalEmprendedores }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-4 text-center">
                <h5>Pedidos</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalPedidos }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-4 text-center">
                <h5>Métodos de pago</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalMetodos }}</p>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card shadow-sm p-4 text-center">
                <h5>Donaciones</h5>
                <p class="display-5" style="color: var(--wayna-orange);">{{ $totalDonaciones }}</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-3">
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h6>Total ventas</h6>
                <p class="h3" style="color: var(--wayna-orange);">Bs. {{ number_format($totalVentas, 2) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h6>Total donaciones</h6>
                <p class="h3" style="color: var(--wayna-orange);">Bs. {{ number_format($totalMontoDonaciones, 2) }}</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm p-4 text-center">
                <h6>Ingreso Wayna</h6>
                <p class="h3" style="color: var(--wayna-orange);">Bs. {{ number_format($ingresosWayna, 2) }}</p>
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card shadow-sm p-4">
                <h5>Top emprendedores por ventas</h5>
                @if($topEmprendedoresVentas->count())
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mt-3">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Emprendedor</th>
                                    <th>Ventas totales</th>
                                    <th>Unidades vendidas</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topEmprendedoresVentas as $index => $emprendedor)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $emprendedor->nombre_emprendimiento }}</td>
                                        <td>Bs. {{ number_format($emprendedor->ventas_totales, 2) }}</td>
                                        <td>{{ $emprendedor->unidades_vendidas }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">No hay ventas registradas aún.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="row g-4 mt-4">
        <div class="col-12">
            <div class="card shadow-sm p-4">
                <h5>Top emprendedores por donaciones</h5>
                @if($topEmprendedoresDonaciones->count())
                    <div class="table-responsive">
                        <table class="table table-sm table-bordered mt-3">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Emprendedor</th>
                                    <th>Total donado</th>
                                    <th>Donaciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topEmprendedoresDonaciones as $index => $emprendedor)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $emprendedor->nombre_emprendimiento }}</td>
                                        <td>Bs. {{ number_format($emprendedor->monto_total, 2) }}</td>
                                        <td>{{ $emprendedor->donaciones_count }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="alert alert-info mb-0">No hay donaciones registradas aún.</div>
                @endif
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-header" style="background: var(--wayna-orange); color: white;">
            <h4 class="mb-0">Panel de administración</h4>
        </div>
        <div class="card-body">
            <p>Como administrador, puedes supervisar el sistema y validar emprendedores, ver pedidos y donaciones.</p>
            <div class="row g-3">
                <div class="col-md-3">
                    <a href="{{ route('admin.emprendedores.index') }}" class="btn btn-outline-light w-100">Gestionar emprendedores</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.productos.index') }}" class="btn btn-outline-light w-100">Gestionar productos</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.metodos.index') }}" class="btn btn-outline-light w-100">Gestionar métodos</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.pedidos') }}" class="btn btn-outline-light w-100">Ver pedidos</a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('admin.donaciones') }}" class="btn btn-outline-light w-100">Ver donaciones</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection