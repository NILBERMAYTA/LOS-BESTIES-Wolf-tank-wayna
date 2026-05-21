@extends('layouts.app')

@section('title', 'Editar QR - ' . $metodo->nombre)

@section('content')
<div class="container py-5">
    <div class="card">
        <div class="card-header" style="background: var(--wayna-orange); color: white;">
            <h5 class="mb-0">Editar QR de método de pago</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <form method="POST" enctype="multipart/form-data" action="{{ route('admin.metodos.update_qr', $metodo->id_metodo) }}">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Método</label>
                    <input class="form-control" value="{{ $metodo->nombre }}" disabled>
                </div>
                <div class="mb-3">
                    <label class="form-label">QR actual</label>
                    @if($metodo->qr_code)
                        <div><img src="{{ asset('storage/' . $metodo->qr_code) }}" style="max-width:200px;"></div>
                    @else
                        <div class="text-muted">No hay QR cargado.</div>
                    @endif
                </div>
                <div class="mb-3">
                    <label class="form-label">Subir nuevo QR (png/jpg/svg)</label>
                    <input type="file" name="qr_file" accept="image/*" class="form-control">
                </div>
                <button class="btn btn-wayna">Guardar</button>
            </form>
        </div>
    </div>
</div>
@endsection
