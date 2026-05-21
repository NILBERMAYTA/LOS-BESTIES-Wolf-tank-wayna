{{-- resources/views/admin/emprendedores/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Administrar Emprendedores')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Gestión de emprendedores</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Volver al panel</a>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-body">
            <form class="row g-2" method="GET" action="{{ route('admin.emprendedores.index') }}">
                <div class="col-md-8">
                    <input type="text" name="search" class="form-control" placeholder="Buscar emprendimiento, email o emprendedor" value="{{ request('search') }}">
                </div>
                <div class="col-auto">
                    <button class="btn btn-wayna">Buscar</button>
                </div>
            </form>
        </div>
    </div>

    @if($emprendedores->count())
        <div class="table-responsive">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Emprendimiento</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Verificado</th>
                        <th>Productos</th>
                        <th>Solicitud</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($emprendedores as $emprendedor)
                        <tr>
                            <td>{{ $emprendedor->id_emprendedor }}</td>
                            <td>{{ $emprendedor->nombre_emprendimiento }}</td>
                            <td>{{ optional($emprendedor->user)->email }}</td>
                            <td>{{ ucfirst($emprendedor->estado_validacion) }}</td>
                            <td>{{ $emprendedor->verificado ? 'Sí' : 'No' }}</td>
                            <td>{{ $emprendedor->productos_count }}</td>
                            <td>{{ $emprendedor->fecha_solicitud ? \\Carbon\\Carbon::parse($emprendedor->fecha_solicitud)->format('d/m/Y') : 'N/A' }}</td>
                            <td class="text-nowrap">
                                <a href="{{ route('admin.emprendedores.show', $emprendedor->id_emprendedor) }}" class="btn btn-sm btn-primary mb-1">Ver</a>
                                <form action="{{ route('admin.emprendedores.update_status', $emprendedor->id_emprendedor) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="{{ $emprendedor->estado_validacion === 'aprobado' ? 'rechazado' : 'aprobado' }}">
                                    <button type="submit" class="btn btn-sm {{ $emprendedor->estado_validacion === 'aprobado' ? 'btn-warning' : 'btn-success' }} mb-1">
                                        {{ $emprendedor->estado_validacion === 'aprobado' ? 'Rechazar' : 'Aprobar' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.emprendedores.destroy', $emprendedor->id_emprendedor) }}" method="POST" class="d-inline-block" onsubmit="return confirm('¿Ocultar este emprendedor?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Ocultar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            {{ $emprendedores->links() }}
        </div>
    @else
        <div class="alert alert-info">No se encontraron emprendedores.</div>
    @endif
</div>
@endsection
