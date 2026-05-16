


<?php $__env->startSection('title', 'Emprendedores'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <h2 class="mb-4">
        <i class="fas fa-store"></i> Nuestros Emprendedores
    </h2>

    <?php if($emprendedores->count()): ?>
        <div class="row g-4">
            <?php $__currentLoopData = $emprendedores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $emprendedor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-4 col-lg-3">
                    <div class="card h-100 shadow-sm hover-scale">
                        
                        <div style="height: 200px; background: #f0f0f0; position: relative; overflow: hidden;">
                            <?php if($emprendedor->foto_perfil): ?>
                                <img src="<?php echo e(asset('storage/' . $emprendedor->foto_perfil)); ?>" 
                                     alt="<?php echo e($emprendedor->nombre_emprendimiento); ?>"
                                     class="w-100 h-100"
                                     style="object-fit: cover;">
                            <?php else: ?>
                                <div class="w-100 h-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, var(--wayna-orange) 0%, #ff8c00 100%);">
                                    <i class="fas fa-store fa-3x text-white"></i>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <?php echo e($emprendedor->nombre_emprendimiento); ?>

                            </h5>

                            <p class="small text-muted mb-2">
                                <i class="fas fa-tag"></i> 
                                <span class="badge" style="background: var(--wayna-orange);">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $emprendedor->categoria))); ?>

                                </span>
                            </p>

                            <p class="card-text small flex-grow-1">
                                <?php echo e(Str::limit($emprendedor->frase_impacto, 80)); ?>

                            </p>

                            <p class="small text-muted">
                                <i class="fas fa-user"></i> <?php echo e($emprendedor->user->nombre); ?>

                            </p>

                            <a href="<?php echo e(route('emprendedor.show', $emprendedor->slug_emprendimiento)); ?>" 
                               class="btn btn-sm w-100" 
                               style="background: var(--wayna-orange); color: white;">
                                Ver Perfil
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="d-flex justify-content-center mt-5">
            <?php echo e($emprendedores->links()); ?>

        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            <i class="fas fa-info-circle"></i> No hay emprendedores disponibles aún.
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEONARDO\Desktop\wayna\LOS-BESTIES-Wolf-tank-wayna\wayna_mercado\resources\views/emprendedor/index.blade.php ENDPATH**/ ?>