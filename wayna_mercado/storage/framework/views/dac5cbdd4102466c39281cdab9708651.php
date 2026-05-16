
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wayna Mercado - <?php echo $__env->yieldContent('title'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/wayna.css')); ?>">
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                WAYNA <span>MERCADO</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('productos.index')); ?>">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo e(route('emprendedores.index')); ?>">Emprendedores</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">
                                <i class="fas fa-sign-in-alt"></i> Ingresar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-wayna ms-2" href="<?php echo e(route('register.emprendedor')); ?>">
                                <i class="fas fa-store"></i> Soy Emprendedor
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle"></i> <?php echo e(Auth::user()->nombre); ?>

                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="<?php echo e(route('dashboard')); ?>"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="<?php echo e(route('logout')); ?>">
                                        <?php echo csrf_field(); ?>
                                        <button class="dropdown-item" type="submit"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div style="margin-top: 76px;">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-check-circle"></i> <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                <i class="fas fa-exclamation-circle"></i> <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5><i class="fas fa-hands-helping"></i> Wayna Mercado</h5>
                    <p>Apoyando a jóvenes emprendedores bolivianos</p>
                </div>
                <div class="col-md-4">
                    <h5>Enlaces</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">Sobre Nosotros</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Síguenos</h5>
                    <a href="#" class="me-2 text-white"><i class="fab fa-facebook fa-lg"></i></a>
                    <a href="#" class="me-2 text-white"><i class="fab fa-instagram fa-lg"></i></a>
                    <a href="#" class="text-white"><i class="fab fa-tiktok fa-lg"></i></a>
                </div>
            </div>
            <hr class="mt-3">
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo e(date('Y')); ?> Wayna Mercado. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Users\LEONARDO\Desktop\wayna\LOS-BESTIES-Wolf-tank-wayna\wayna_mercado\resources\views/layouts/app.blade.php ENDPATH**/ ?>