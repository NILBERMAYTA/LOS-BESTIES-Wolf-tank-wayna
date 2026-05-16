


<?php $__env->startSection('title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <?php if(Auth::check() && Auth::user()->id_rol == 2): ?>
        
        <?php
            $emprendedor = Auth::user()->emprendedor;
        ?>

        <?php if($emprendedor): ?>
            <?php
                $productosRecientes = $emprendedor->productos()->take(5)->get();
                $productoCount = $totalProductos;
            ?>
            <div class="row mb-4">
                <div class="col-md-8">
                    <h2 class="mb-3">
                        <i class="fas fa-store"></i> Bienvenido, <?php echo e(Auth::user()->nombre); ?>

                    </h2>
                    <p class="text-muted">Aquí está tu espacio para gestionar tu emprendimiento</p>
                </div>
                <div class="col-md-4 text-end">
                    <span class="badge badge-wayna px-3 py-2" style="font-size: 1.1em;">
                        <?php if($emprendedor->estado_validacion == 'aprobado'): ?>
                            <i class="fas fa-check-circle"></i> Aprobado
                        <?php else: ?>
                            <i class="fas fa-clock"></i> <?php echo e(ucfirst($emprendedor->estado_validacion)); ?>

                        <?php endif; ?>
                    </span>
                </div>
            </div>

            
            <div class="row mb-5">
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-cube fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Productos</p>
                            <h3 style="color: var(--wayna-orange);">
                                <?php echo e($totalProductos); ?>

                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-shopping-cart fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Ventas</p>
                            <h3 style="color: var(--wayna-orange);">
                                Bs. <?php echo e(number_format($totalVentas, 2)); ?>

                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-boxes fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Unidades vendidas</p>
                            <h3 style="color: var(--wayna-orange);">
                                <?php echo e($totalUnidadesVendidas); ?>

                            </h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-hand-holding-heart fa-3x mb-3" style="color: var(--wayna-orange);"></i>
                            <p class="text-muted">Donaciones</p>
                            <h3 style="color: var(--wayna-orange);">
                                Bs. <?php echo e(number_format($totalDonaciones, 2)); ?>

                            </h3>
                        </div>
                    </div>
                </div>
            </div>

            
            <div class="row">
                <div class="col-md-8">
                    <div class="card shadow mb-4">
                        <div class="card-header" style="background: var(--wayna-orange); color: white;">
                            <h5 class="mb-0">
                                <i class="fas fa-briefcase"></i> <?php echo e($emprendedor->nombre_emprendimiento); ?>

                            </h5>
                        </div>
                        <div class="card-body">
                            <p class="mb-3">
                                <strong>Categoría:</strong> 
                                <span class="badge badge-wayna">
                                    <?php echo e(ucfirst(str_replace('_', ' ', $emprendedor->categoria))); ?>

                                </span>
                            </p>

                            <?php if($emprendedor->frase_impacto): ?>
                                <p class="mb-3">
                                    <strong>Frase de impacto:</strong><br>
                                    <em><?php echo e($emprendedor->frase_impacto); ?></em>
                                </p>
                            <?php endif; ?>

                            <?php if($emprendedor->biografia): ?>
                                <p class="mb-3">
                                    <strong>Tu historia:</strong><br>
                                    <?php echo e(\Illuminate\Support\Str::limit($emprendedor->biografia, 200)); ?>

                                </p>
                            <?php endif; ?>

                            <a href="<?php echo e(route('emprendedor.show', $emprendedor->slug_emprendimiento)); ?>" 
                               class="btn btn-wayna">
                                <i class="fas fa-eye"></i> Ver mi perfil público
                            </a>
                        </div>
                    </div>

                    
                    <div class="card shadow">
                        <div class="card-header" style="background: var(--wayna-orange); color: white;">
                            <h5 class="mb-0">
                                <i class="fas fa-cube"></i> Mis Productos (<?php echo e($productoCount); ?>)
                            </h5>
                        </div>
                        <div class="card-body">
                            <?php if($productoCount > 0): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-wayna">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Precio</th>
                                                <th>Stock</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $__currentLoopData = $productosRecientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $producto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td><?php echo e($producto->nombre_producto); ?></td>
                                                    <td>Bs. <?php echo e(number_format($producto->precio, 2)); ?></td>
                                                    <td><?php echo e($producto->stock); ?></td>
                                                    <td>
                                                        <span class="badge badge-wayna-status <?php echo e($producto->estado == 'activo' ? 'active' : 'inactive'); ?>">
                                                            <?php echo e(ucfirst($producto->estado)); ?>

                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                                <p class="text-center mt-3">
                                    <a href="<?php echo e(route('emprendedor.productos', $emprendedor->slug_emprendimiento)); ?>" 
                                       class="btn btn-sm btn-outline-warning">
                                        Ver todos los productos
                                    </a>
                                </p>
                            <?php else: ?>
                                <div class="alert alert-info mb-0">
                                    <i class="fas fa-info-circle"></i> Aún no has publicado productos.
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                
                <div class="col-md-4">
                    <div class="card shadow">
                        <div class="card-header" style="background: var(--wayna-orange); color: white;">
                            <h5 class="mb-0">
                                <i class="fas fa-cogs"></i> Acciones Rápidas
                            </h5>
                        </div>
                        <div class="card-body">
                            <a href="<?php echo e(route('producto.create')); ?>" class="btn btn-outline-warning w-100 mb-2">
                                <i class="fas fa-plus"></i> Nuevo Producto
                            </a>
                            <a href="<?php echo e(route('emprendedor.editPerfil')); ?>" class="btn btn-outline-warning w-100 mb-2">
                                <i class="fas fa-edit"></i> Editar Perfil
                            </a>
                            <button class="btn btn-outline-warning w-100 mb-2" data-bs-toggle="modal" data-bs-target="#modalFotos">
                                <i class="fas fa-images"></i> Fotos
                            </button>
                            <button class="btn btn-outline-warning w-100" data-bs-toggle="modal" data-bs-target="#modalEstadisticas">
                                <i class="fas fa-chart-bar"></i> Estadísticas
                            </button>
                        </div>
                    </div>

                    
                    <div class="card shadow mt-3">
                        <div class="card-body">
                            <?php if($emprendedor->verificado): ?>
                                <p class="mb-0">
                                    <i class="fas fa-check-circle" style="color: green;"></i> 
                                    <strong>Tu cuenta está verificada</strong>
                                </p>
                            <?php else: ?>
                                <p class="mb-0">
                                    <i class="fas fa-hourglass" style="color: orange;"></i> 
                                    <strong>Verificación pendiente</strong>
                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> 
                No tiene un perfil de emprendedor creado. 
                <a href="<?php echo e(route('register.emprendedor')); ?>">Crear perfil</a>
            </div>
        <?php endif; ?>
    <?php else: ?>
        
        <div class="card shadow">
            <div class="card-header" style="background: var(--wayna-orange); color: white;">
                <h4 class="mb-0">Acceso Restringido</h4>
            </div>
            <div class="card-body text-center">
                <i class="fas fa-lock fa-3x mb-3 text-muted"></i>
                <p>Este espacio está reservado para emprendedores.</p>
                <a href="<?php echo e(route('register.emprendedor')); ?>" class="btn" style="background: var(--wayna-orange); color: white;">
                    ¿Eres emprendedor? Regístrate aquí
                </a>
            </div>
        </div>
    <?php endif; ?>
</div>



<div class="modal fade" id="modalFotos" tabindex="-1" aria-labelledby="modalFotosLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalFotosLabel"><i class="fas fa-images"></i> Fotos del emprendimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <h6>Foto de perfil</h6>
                        <?php if($emprendedor->foto_perfil): ?>
                            <img src="<?php echo e(asset('storage/' . $emprendedor->foto_perfil)); ?>" class="img-fluid rounded" alt="Foto de perfil">
                        <?php else: ?>
                            <div class="p-5 text-center" style="background:#f5f5f5;">
                                <i class="fas fa-user fa-3x text-muted"></i>
                                <p class="mt-2">Sin foto de perfil</p>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <h6>Foto de portada</h6>
                        <?php if($emprendedor->foto_portada): ?>
                            <img src="<?php echo e(asset('storage/' . $emprendedor->foto_portada)); ?>" class="img-fluid rounded" alt="Foto de portada">
                        <?php else: ?>
                            <div class="p-5 text-center" style="background:#f5f5f5;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                                <p class="mt-2">Sin foto de portada</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <a href="<?php echo e(route('emprendedor.editPerfil')); ?>" class="btn btn-outline-warning">Editar fotos</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalEstadisticas" tabindex="-1" aria-labelledby="modalEstadisticasLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEstadisticasLabel"><i class="fas fa-chart-bar"></i> Estadísticas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <h6>Productos</h6>
                        <p class="h4"><?php echo e($totalProductos ?? 0); ?></p>
                    </div>
                    <div class="col-6">
                        <h6>Ventas (Bs.)</h6>
                        <p class="h4"><?php echo e(number_format($totalVentas ?? 0, 2)); ?></p>
                    </div>
                    <div class="col-6">
                        <h6>Unidades vendidas</h6>
                        <p class="h5"><?php echo e($totalUnidadesVendidas ?? 0); ?></p>
                    </div>
                    <div class="col-6">
                        <h6>Donaciones (Bs.)</h6>
                        <p class="h5"><?php echo e(number_format($totalDonaciones ?? 0, 2)); ?></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEONARDO\Desktop\wayna\LOS-BESTIES-Wolf-tank-wayna\wayna_mercado\resources\views/emprendedor/dashboard.blade.php ENDPATH**/ ?>