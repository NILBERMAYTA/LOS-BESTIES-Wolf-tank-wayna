


<?php $__env->startSection('title', 'Donaciones Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Donaciones</h2>
            <p class="text-muted mb-0">Lista de donaciones recibidas por emprendedores.</p>
        </div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Volver al panel</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if($donaciones->count()): ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Emprendedor</th>
                                <th>Monto</th>
                                <th>Fecha</th>
                                <th>Mensaje</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $donaciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $donacion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($donacion->id_donacion); ?></td>
                                    <td><?php echo e($donacion->cliente->nombre ?? 'Cliente'); ?> <?php echo e($donacion->cliente->apellido ?? ''); ?></td>
                                    <td><?php echo e($donacion->emprendedor->nombre_emprendimiento ?? 'Emprendedor'); ?></td>
                                    <td>Bs. <?php echo e(number_format($donacion->monto, 2)); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($donacion->fecha_donacion)->format('d/m/Y H:i')); ?></td>
                                    <td><?php echo e($donacion->mensaje_apoyo ?? '-'); ?></td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($donaciones->links()); ?>

                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">
                    No hay donaciones registradas todavía.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEONARDO\Desktop\wayna\LOS-BESTIES-Wolf-tank-wayna\wayna_mercado\resources\views/dashboard/admin-donaciones.blade.php ENDPATH**/ ?>