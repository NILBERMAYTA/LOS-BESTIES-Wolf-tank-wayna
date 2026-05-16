


<?php $__env->startSection('title', 'Productos'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Productos</h2>
            <p class="text-muted">Encuentra productos disponibles de emprendedores aprobados.</p>
        </div>
        <a href="<?php echo e(route('emprendedores.index')); ?>" class="btn btn-outline-wayna">
            <i class="fas fa-store"></i> Ver emprendedores
        </a>
    </div>

    <?php if($productos->count()): ?>
        <div class="row g-4">
            <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm">
                        <div style="height: 230px; overflow: hidden; background: #f5f5f5;">
                            <?php if($producto->imagen_principal): ?>
                                <img src="<?php echo e(asset('storage/' . $producto->imagen_principal)); ?>" class="w-100 h-100" style="object-fit: cover;" alt="<?php echo e($producto->nombre_producto); ?>">
                            <?php else: ?>
                                <div class="d-flex align-items-center justify-content-center h-100" style="background: #e9ecef;">
                                    <i class="fas fa-box-open fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo e($producto->nombre_producto); ?></h5>
                            <?php if($producto->categoria): ?>
                                <p class="small text-muted mb-2"><?php echo e($producto->categoria->nombre_categoria); ?></p>
                            <?php endif; ?>

                            <p class="text-muted small flex-grow-1"><?php echo e(\Illuminate\Support\Str::limit($producto->descripcion_corta ?? $producto->descripcion_larga, 90)); ?></p>

                            <p class="h5 mb-2" style="color: var(--wayna-orange);">
                                Bs. <?php echo e(number_format($producto->precio, 2)); ?>

                            </p>
                            <p class="small text-muted mb-3">
                                <i class="fas fa-store"></i> <?php echo e($producto->emprendedor->nombre_emprendimiento); ?>

                            </p>

                            <a href="<?php echo e(route('producto.show', $producto->slug)); ?>" class="btn btn-wayna mt-auto">
                                Ver producto
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="d-flex justify-content-center mt-5">
            <?php echo e($productos->links()); ?>

        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="fas fa-info-circle"></i> No hay productos disponibles en este momento.
        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEONARDO\Desktop\wayna\LOS-BESTIES-Wolf-tank-wayna\wayna_mercado\resources\views/productos/index.blade.php ENDPATH**/ ?>