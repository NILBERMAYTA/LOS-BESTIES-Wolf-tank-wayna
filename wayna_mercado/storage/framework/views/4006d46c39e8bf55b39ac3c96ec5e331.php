


<?php $__env->startSection('title', $emprendedor->nombre_emprendimiento); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    
    <?php if($emprendedor->foto_portada): ?>
        <div class="mb-4" style="height: 300px; border-radius: 10px; overflow: hidden; background: #f0f0f0;">
            <img src="<?php echo e(asset('storage/' . $emprendedor->foto_portada)); ?>" 
                 alt="Portada"
                 class="w-100 h-100"
                 style="object-fit: cover;">
        </div>
    <?php else: ?>
        <div class="mb-4" style="height: 300px; border-radius: 10px; background: linear-gradient(135deg, var(--wayna-orange) 0%, #ff8c00 100%);"></div>
    <?php endif; ?>

    
    <div class="row mb-5">
        
        <div class="col-md-4">
            <div class="card shadow">
                
                <div style="height: 250px; background: #f0f0f0; overflow: hidden;">
                    <?php if($emprendedor->foto_perfil): ?>
                        <img src="<?php echo e(asset('storage/' . $emprendedor->foto_perfil)); ?>" 
                             alt="<?php echo e($emprendedor->nombre_emprendimiento); ?>"
                             class="w-100 h-100"
                             style="object-fit: cover;">
                    <?php else: ?>
                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--wayna-orange) 0%, #ff8c00 100%);">
                            <i class="fas fa-store fa-4x text-white"></i>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="card-body">
                    <h4 class="card-title"><?php echo e($emprendedor->nombre_emprendimiento); ?></h4>
                    
                    <p class="text-muted">
                        <strong><?php echo e($emprendedor->user->nombre); ?> <?php echo e($emprendedor->user->apellido); ?></strong>
                    </p>

                    
                    <p class="mb-3">
                        <span class="badge" style="background: var(--wayna-orange); font-size: 0.9em;">
                            <i class="fas fa-tag"></i> <?php echo e(ucfirst(str_replace('_', ' ', $emprendedor->categoria))); ?>

                        </span>
                    </p>

                    
                    <?php if($emprendedor->user->telefono): ?>
                        <p class="mb-2">
                            <i class="fas fa-phone"></i> <strong>Teléfono:</strong> <?php echo e($emprendedor->user->telefono); ?>

                        </p>
                    <?php endif; ?>

                    <?php if($emprendedor->ubicacion): ?>
                        <p class="mb-2">
                            <i class="fas fa-map-marker-alt"></i> <strong>Ubicación:</strong> <?php echo e($emprendedor->ubicacion); ?>

                        </p>
                    <?php endif; ?>

                    
                    <?php if($emprendedor->video_url): ?>
                        <a href="<?php echo e($emprendedor->video_url); ?>" target="_blank" class="btn btn-sm btn-outline-danger w-100">
                            <i class="fab fa-youtube"></i> Ver Presentación
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        
        <div class="col-md-8">
            
            <?php if($emprendedor->frase_impacto): ?>
                <div class="card mb-4 border-0" style="background: linear-gradient(135deg, rgba(255, 140, 0, 0.1) 0%, rgba(255, 140, 0, 0.05) 100%);">
                    <div class="card-body">
                        <p class="lead mb-0" style="color: var(--wayna-orange);">
                            <i class="fas fa-quote-left"></i> <?php echo e($emprendedor->frase_impacto); ?>

                        </p>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($emprendedor->biografia): ?>
                <div class="card mb-4">
                    <div class="card-header" style="background: var(--wayna-orange); color: white;">
                        <h5 class="mb-0"><i class="fas fa-user"></i> Historia de Vida</h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo e($emprendedor->biografia); ?></p>
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if($emprendedor->descripcion_emprendimiento): ?>
                <div class="card mb-4">
                    <div class="card-header" style="background: var(--wayna-orange); color: white;">
                        <h5 class="mb-0"><i class="fas fa-briefcase"></i> Sobre el Emprendimiento</h5>
                    </div>
                    <div class="card-body">
                        <p><?php echo e($emprendedor->descripcion_emprendimiento); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">
                <i class="fas fa-cube"></i> Productos 
                <span class="badge" style="background: var(--wayna-orange);"><?php echo e($productos->count()); ?></span>
            </h3>

            <?php if($productos->count()): ?>
                <div class="row g-4">
                    <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="card h-100 shadow-sm">
                                
                                <div style="height: 200px; background: #f0f0f0; overflow: hidden;">
                                    <?php if($producto->imagen_principal): ?>
                                        <img src="<?php echo e(asset('storage/' . $producto->imagen_principal)); ?>" 
                                             alt="<?php echo e($producto->nombre_producto); ?>"
                                             class="w-100 h-100"
                                             style="object-fit: cover;">
                                    <?php else: ?>
                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: #e0e0e0;">
                                            <i class="fas fa-image fa-2x text-muted"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card-body">
                                    <h5 class="card-title"><?php echo e($producto->nombre_producto); ?></h5>
                                    
                                    <p class="text-muted small mb-2">
                                        <?php echo e(Str::limit($producto->descripcion_corta ?? $producto->descripcion_larga, 80)); ?>

                                    </p>

                                    <p class="mb-2">
                                        <strong style="color: var(--wayna-orange); font-size: 1.2em;">
                                            Bs. <?php echo e(number_format($producto->precio, 2)); ?>

                                        </strong>
                                    </p>

                                    
                                    <p class="small mb-2">
                                        <?php if($producto->stock > 0): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> Stock: <?php echo e($producto->stock); ?>

                                            </span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> Agotado
                                            </span>
                                        <?php endif; ?>
                                    </p>

                                    
                                    <?php if($producto->calificacion_promedio > 0): ?>
                                        <p class="mb-0 small">
                                            <i class="fas fa-star" style="color: var(--wayna-orange);"></i>
                                            <?php echo e(number_format($producto->calificacion_promedio, 1)); ?> 
                                            (<?php echo e($producto->total_reseñas); ?> reseñas)
                                        </p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Este emprendedor aún no tiene productos publicados.
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEONARDO\Desktop\wayna\LOS-BESTIES-Wolf-tank-wayna\wayna_mercado\resources\views/emprendedor/show.blade.php ENDPATH**/ ?>