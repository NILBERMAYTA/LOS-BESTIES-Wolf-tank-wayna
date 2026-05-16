


<?php $__env->startSection('title', 'Editar Mi Perfil'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card shadow">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h4 class="mb-0">
                        <i class="fas fa-user-edit"></i> Editar Mi Perfil
                    </h4>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('emprendedor.updatePerfil')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>

                        
                        <h5 class="mb-3 mt-4">
                            <i class="fas fa-images"></i> Fotos
                        </h5>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foto_perfil" class="form-label">Foto de Perfil</label>
                                    <?php if($emprendedor->foto_perfil): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo e(asset('storage/' . $emprendedor->foto_perfil)); ?>" 
                                                 alt="Foto de perfil" style="max-height: 150px; border-radius: 50%;" class="img-thumbnail">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control <?php $__errorArgs = ['foto_perfil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="foto_perfil" name="foto_perfil" accept="image/*">
                                    <small class="form-text text-muted">PNG, JPG, GIF. Máximo 5MB</small>
                                    <?php $__errorArgs = ['foto_perfil'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="foto_portada" class="form-label">Foto de Portada</label>
                                    <?php if($emprendedor->foto_portada): ?>
                                        <div class="mb-2">
                                            <img src="<?php echo e(asset('storage/' . $emprendedor->foto_portada)); ?>" 
                                                 alt="Foto de portada" style="max-height: 150px;" class="img-thumbnail">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control <?php $__errorArgs = ['foto_portada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="foto_portada" name="foto_portada" accept="image/*">
                                    <small class="form-text text-muted">PNG, JPG, GIF. Máximo 5MB</small>
                                    <?php $__errorArgs = ['foto_portada'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <hr>

                        
                        <h5 class="mb-3">
                            <i class="fas fa-briefcase"></i> Tu Emprendimiento
                        </h5>

                        <div class="mb-3">
                            <label for="nombre_emprendimiento" class="form-label">Nombre del Emprendimiento *</label>
                            <input type="text" class="form-control <?php $__errorArgs = ['nombre_emprendimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="nombre_emprendimiento" name="nombre_emprendimiento" 
                                   value="<?php echo e(old('nombre_emprendimiento', $emprendedor->nombre_emprendimiento)); ?>" required>
                            <?php $__errorArgs = ['nombre_emprendimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion_emprendimiento" class="form-label">Descripción Breve</label>
                            <input type="text" maxlength="255" class="form-control <?php $__errorArgs = ['descripcion_emprendimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="descripcion_emprendimiento" name="descripcion_emprendimiento" 
                                   value="<?php echo e(old('descripcion_emprendimiento', $emprendedor->descripcion_emprendimiento)); ?>">
                            <small class="form-text text-muted">Máximo 255 caracteres</small>
                            <?php $__errorArgs = ['descripcion_emprendimiento'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="frase_impacto" class="form-label">Frase de Impacto *</label>
                            <input type="text" maxlength="255" class="form-control <?php $__errorArgs = ['frase_impacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="frase_impacto" name="frase_impacto" 
                                   value="<?php echo e(old('frase_impacto', $emprendedor->frase_impacto)); ?>" required>
                            <small class="form-text text-muted">Una frase que represente tu emprendimiento. Máximo 255 caracteres</small>
                            <?php $__errorArgs = ['frase_impacto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="mb-3">
                            <label for="biografia" class="form-label">Tu Historia *</label>
                            <textarea class="form-control <?php $__errorArgs = ['biografia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                      id="biografia" name="biografia" rows="5" required><?php echo e(old('biografia', $emprendedor->biografia)); ?></textarea>
                            <?php $__errorArgs = ['biografia'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="categoria" class="form-label">Categoría *</label>
                                    <select class="form-select <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                            id="categoria" name="categoria" required>
                                        <option value="">Selecciona una categoría</option>
                                        <option value="gastronomia" <?php echo e(old('categoria', $emprendedor->categoria) == 'gastronomia' ? 'selected' : ''); ?>>
                                            Gastronomía
                                        </option>
                                        <option value="cosmetica" <?php echo e(old('categoria', $emprendedor->categoria) == 'cosmetica' ? 'selected' : ''); ?>>
                                            Cosmética
                                        </option>
                                        <option value="artesania" <?php echo e(old('categoria', $emprendedor->categoria) == 'artesania' ? 'selected' : ''); ?>>
                                            Artesanía
                                        </option>
                                        <option value="textiles" <?php echo e(old('categoria', $emprendedor->categoria) == 'textiles' ? 'selected' : ''); ?>>
                                            Textiles
                                        </option>
                                        <option value="otros" <?php echo e(old('categoria', $emprendedor->categoria) == 'otros' ? 'selected' : ''); ?>>
                                            Otros
                                        </option>
                                    </select>
                                    <?php $__errorArgs = ['categoria'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback d-block"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="ubicacion" class="form-label">Ubicación</label>
                                    <input type="text" maxlength="150" class="form-control <?php $__errorArgs = ['ubicacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                           id="ubicacion" name="ubicacion" 
                                           value="<?php echo e(old('ubicacion', $emprendedor->ubicacion)); ?>">
                                    <?php $__errorArgs = ['ubicacion'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback"><?php echo e($message); ?></div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                            <a href="<?php echo e(route('emprendedor.dashboard')); ?>" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Cancelar
                            </a>
                            <button type="submit" class="btn" style="background: var(--wayna-orange); color: white;">
                                <i class="fas fa-save"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEONARDO\Desktop\wayna\LOS-BESTIES-Wolf-tank-wayna\wayna_mercado\resources\views/emprendedor/edit-perfil.blade.php ENDPATH**/ ?>