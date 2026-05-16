


<?php $__env->startSection('title', 'Pedidos Admin'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Pedidos</h2>
            <p class="text-muted mb-0">Lista de compras realizadas por clientes.</p>
        </div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-secondary">Volver al panel</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if($pedidos->count()): ?>
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
                            <?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($pedido->id_pedido); ?></td>
                                    <td><?php echo e($pedido->cliente->nombre ?? 'Cliente'); ?> <?php echo e($pedido->cliente->apellido ?? ''); ?></td>
                                    <td><?php echo e(\Carbon\Carbon::parse($pedido->fecha_pedido)->format('d/m/Y H:i')); ?></td>
                                    <td>Bs. <?php echo e(number_format($pedido->total, 2)); ?></td>
                                    <td><?php echo e(ucfirst($pedido->estado_pedido)); ?></td>
                                    <td>
                                        <?php $__currentLoopData = $pedido->detalles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detalle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div>
                                                <strong><?php echo e($detalle->producto->nombre_producto ?? 'Producto'); ?></strong>
                                                x <?php echo e($detalle->cantidad); ?>

                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    <?php echo e($pedidos->links()); ?>

                </div>
            <?php else: ?>
                <div class="alert alert-info mb-0">
                    No hay pedidos registrados todavía.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEONARDO\Desktop\wayna\LOS-BESTIES-Wolf-tank-wayna\wayna_mercado\resources\views/dashboard/admin-pedidos.blade.php ENDPATH**/ ?>