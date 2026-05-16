


<?php $__env->startSection('title', 'Productos - ' . $emprendedor->nombre_emprendimiento); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    
    <div class="mb-5">
        <h2 class="mb-3">
            <i class="fas fa-cube"></i> Productos de <?php echo e($emprendedor->nombre_emprendimiento); ?>

        </h2>
        <p class="text-muted">
            <a href="<?php echo e(route('emprendedor.show', $emprendedor->slug_emprendimiento)); ?>">
                <i class="fas fa-arrow-left"></i> Volver al perfil
            </a>
        </p>
    </div>

    <?php if($productos->count()): ?>
        <div class="row g-4">
            <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm hover-scale">
                        
                        <div style="height: 250px; background: #f0f0f0; overflow: hidden; position: relative;">
                            <?php if($producto->imagen_principal): ?>
                                <img src="<?php echo e(asset('storage/' . $producto->imagen_principal)); ?>" 
                                     alt="<?php echo e($producto->nombre_producto); ?>"
                                     class="w-100 h-100"
                                     style="object-fit: cover;">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: #e0e0e0;">
                                    <i class="fas fa-image fa-3x text-muted"></i>
                                </div>
                            <?php endif; ?>

                            
                            <?php if($producto->destacado): ?>
                                <span class="badge" style="background: var(--wayna-orange); position: absolute; top: 10px; right: 10px;">
                                    <i class="fas fa-star"></i> Destacado
                                </span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?php echo e($producto->nombre_producto); ?></h5>
                            
                            
                            <?php if($producto->categoria): ?>
                                <p class="small mb-2">
                                    <span class="badge bg-light text-dark">
                                        <?php echo e($producto->categoria->nombre_categoria); ?>

                                    </span>
                                </p>
                            <?php endif; ?>

                            
                            <p class="text-muted small flex-grow-1">
                                <?php echo e(Str::limit($producto->descripcion_corta ?? $producto->descripcion_larga, 100)); ?>

                            </p>

                            
                            <p class="h5 mb-2">
                                <strong style="color: var(--wayna-orange);">
                                    Bs. <?php echo e(number_format($producto->precio, 2)); ?>

                                </strong>
                            </p>

                            
                            <p class="small mb-3">
                                <?php if($producto->stock > 0): ?>
                                    <span class="badge bg-success">
                                        <i class="fas fa-check"></i> Stock: <?php echo e($producto->stock); ?>

                                    </span>
                                <?php elseif($producto->estado == 'agotado'): ?>
                                    <span class="badge bg-warning text-dark">
                                        <i class="fas fa-exclamation"></i> Agotado
                                    </span>
                                <?php else: ?>
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times"></i> No disponible
                                    </span>
                                <?php endif; ?>
                            </p>

                            
                            <?php if($producto->calificacion_promedio > 0): ?>
                                <p class="small mb-3">
                                    <?php for($i = 0; $i < 5; $i++): ?>
                                        <?php if($i < floor($producto->calificacion_promedio)): ?>
                                            <i class="fas fa-star" style="color: var(--wayna-orange);"></i>
                                        <?php elseif($i < ceil($producto->calificacion_promedio)): ?>
                                            <i class="fas fa-star-half-alt" style="color: var(--wayna-orange);"></i>
                                        <?php else: ?>
                                            <i class="far fa-star" style="color: var(--wayna-orange);"></i>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                    <strong><?php echo e(number_format($producto->calificacion_promedio, 1)); ?></strong>
                                    (<?php echo e($producto->total_reseñas); ?> reseñas)
                                </p>
                            <?php endif; ?>

                            
                            <button class="btn btn-outline-warning w-100">
                                <i class="fas fa-heart"></i> Agregar a favoritos
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="d-flex justify-content-center mt-5">
            <?php echo e($productos->links()); ?>

        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No hay productos disponibles.
        </div>
    <?php endif; ?>
</div>

<style>
    .hover-scale {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEONARDO\Desktop\wayna\LOS-BESTIES-Wolf-tank-wayna\wayna_mercado\resources\views/emprendedor/productos.blade.php ENDPATH**/ ?>