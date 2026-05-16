


<?php $__env->startSection('title', $producto->nombre_producto); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-5">
    <?php if(session('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php echo e(session('success')); ?>

            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card shadow-sm">
                <div style="height: 420px; overflow: hidden; background: #f8f9fa;">
                    <?php if($producto->imagen_principal): ?>
                        <img src="<?php echo e(asset('storage/' . $producto->imagen_principal)); ?>" class="w-100 h-100" style="object-fit: cover;" alt="<?php echo e($producto->nombre_producto); ?>">
                    <?php else: ?>
                        <div class="d-flex align-items-center justify-content-center h-100" style="background: #e9ecef;">
                            <i class="fas fa-image fa-4x text-muted"></i>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="card-body">
                    <h3><?php echo e($producto->nombre_producto); ?></h3>
                    <p class="text-muted mb-2">
                        <?php echo e($producto->categoria->nombre_categoria ?? 'Sin categoría'); ?>

                    </p>
                    <p class="text-muted small mb-3">
                        Emprendedor: <strong><?php echo e($producto->emprendedor->nombre_emprendimiento); ?></strong>
                    </p>
                    <p class="mb-3"><?php echo e($producto->descripcion_larga ?? $producto->descripcion_corta); ?></p>
                    <div class="mb-3">
                        <span class="badge bg-warning text-dark">
                            Bs. <?php echo e(number_format($producto->precio, 2)); ?>

                        </span>
                        <span class="badge bg-<?php echo e($producto->stock > 0 ? 'success' : 'danger'); ?> text-white">
                            <?php echo e($producto->stock > 0 ? 'Stock: ' . $producto->stock : 'Agotado'); ?>

                        </span>
                    </div>
                    <div class="mb-3">
                        <small class="text-muted">
                            Producto publicado por <a href="<?php echo e(route('emprendedor.show', $producto->emprendedor->slug_emprendimiento)); ?>"><?php echo e($producto->emprendedor->nombre_emprendimiento); ?></a>
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h5 class="mb-0"><i class="fas fa-shopping-cart"></i> Comprar</h5>
                </div>
                <div class="card-body">
                    <?php if(auth()->guard()->guest()): ?>
                        <p class="mb-3">Debes iniciar sesión para comprar este producto.</p>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-wayna w-100">Ingresar</a>
                    <?php else: ?>
                        <form method="POST" action="<?php echo e(route('producto.comprar', $producto->slug)); ?>" id="form-comprar">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label class="form-label">Cantidad</label>
                                <input type="number" name="cantidad" id="cantidad-compra" class="form-control" min="1" value="1" <?php echo e($producto->stock <= 0 ? 'disabled' : ''); ?>>
                                <?php $__errorArgs = ['cantidad'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Método de pago</label>
                                <select name="payment_method_id" id="payment-method-compra" class="form-control" required <?php echo e($producto->stock <= 0 ? 'disabled' : ''); ?>>
                                    <option value="">Seleccionar</option>
                                    <option value="wayna_qr" data-qr="metodos/qr_wayna.jpg" data-codigo="">Wayna QR (Escanear QR de la empresa)</option>
                                    <option value="yape" data-qr="" data-codigo="">Yape</option>
                                    <option value="plin" data-qr="" data-codigo="">Plin</option>
                                    <option value="transferencia_bancaria" data-qr="" data-codigo="">Transferencia bancaria</option>
                                    <?php $__currentLoopData = $metodosPago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($metodo->id_metodo); ?>" data-qr="<?php echo e($metodo->qr_code ?? ''); ?>" data-codigo="<?php echo e($metodo->codigo ?? ''); ?>"><?php echo e($metodo->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['payment_method_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div id="qr-area-compra" class="mb-3" style="display:none;">
                                <label class="form-label">QR para pago</label>
                                <div id="qr-container-compra" style="padding:12px; background:#fff; border:1px solid #e9e9e9; max-width:260px"></div>
                                <div id="qr-note-compra" class="small text-muted mt-2">Escanea el QR con tu app de pagos para completar.</div>
                                <div id="qr-message-compra" class="small text-danger mt-2" style="display:none;"></div>
                            </div>
                            <div id="bank-info-compra" class="mb-3" style="display:none;">
                                <div class="alert alert-info small mb-0">
                                    <strong>Transferencia bancaria:</strong> Banco Unión - Cuenta corriente 1234567890 - CCI 06012345678901234567
                                </div>
                            </div>

                            <button type="submit" class="btn btn-wayna w-100" <?php echo e($producto->stock <= 0 ? 'disabled' : ''); ?>>
                                Comprar ahora
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header" style="background: var(--wayna-orange); color: white;">
                    <h5 class="mb-0"><i class="fas fa-hand-holding-heart"></i> Donar</h5>
                </div>
                <div class="card-body">
                    <?php if(auth()->guard()->guest()): ?>
                        <p class="mb-3">Inicia sesión para poder donar.</p>
                        <a href="<?php echo e(route('login')); ?>" class="btn btn-wayna w-100">Ingresar</a>
                    <?php else: ?>
                        <form method="POST" action="<?php echo e(route('producto.donar', $producto->slug)); ?>" id="form-donar">
                            <?php echo csrf_field(); ?>
                            <div class="mb-3">
                                <label class="form-label">Monto de donación (Bs.)</label>
                                <input type="number" name="monto" id="monto-donar" class="form-control" min="1" step="0.01" value="10" required>
                                <?php $__errorArgs = ['monto'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Método de pago</label>
                                <select name="payment_method_id" id="payment-method-donar" class="form-control" required>
                                    <option value="">Seleccionar</option>
                                    <option value="wayna_qr" data-qr="metodos/qr_wayna.jpg" data-codigo="">Wayna QR (Escanear QR de la empresa)</option>
                                    <option value="yape" data-qr="" data-codigo="">Yape</option>
                                    <option value="plin" data-qr="" data-codigo="">Plin</option>
                                    <option value="transferencia_bancaria" data-qr="" data-codigo="">Transferencia bancaria</option>
                                    <?php $__currentLoopData = $metodosPago; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $metodo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($metodo->id_metodo); ?>" data-qr="<?php echo e($metodo->qr_code ?? ''); ?>" data-codigo="<?php echo e($metodo->codigo ?? ''); ?>"><?php echo e($metodo->nombre); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <?php $__errorArgs = ['payment_method_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger small"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <div id="qr-area-donar" class="mb-3" style="display:none;">
                                <label class="form-label">QR para donación</label>
                                <div id="qr-container-donar" style="padding:12px; background:#fff; border:1px solid #e9e9e9; max-width:260px"></div>
                                <div id="qr-note-donar" class="small text-muted mt-2">Escanea el QR con tu app de pagos para completar.</div>
                                <div id="qr-message-donar" class="small text-danger mt-2" style="display:none;"></div>
                            </div>
                            <div id="bank-info-donar" class="mb-3" style="display:none;">
                                <div class="alert alert-info small mb-0">
                                    <strong>Transferencia bancaria:</strong> Banco Unión - Cuenta corriente 1234567890 - CCI 06012345678901234567
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-wayna w-100">
                                Donar ahora
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="payment-data" 
     data-product-price="<?php echo e($producto->precio); ?>" 
     data-product-slug="<?php echo e($producto->slug); ?>" 
     data-storage-url="<?php echo e(asset('storage')); ?>" 
     data-company-qr-url="<?php echo e(asset('storage/metodos/qr_wayna.jpg')); ?>" 
     data-company-public-qr="<?php echo e(asset('images/company-qr.svg')); ?>" 
     style="display:none;"></div>

<?php $__env->startPush('scripts'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
    <script>
        (function(){
            var paymentData = document.getElementById('payment-data');
            var PRODUCT_PRICE = parseFloat(paymentData.dataset.productPrice) || 0;
            var STORAGE_URL = paymentData.dataset.storageUrl || '';
            var PRODUCT_SLUG = paymentData.dataset.productSlug || '';
            var COMPANY_QR_URL = paymentData.dataset.companyQrUrl || '';
            var COMPANY_PUBLIC_QR = paymentData.dataset.companyPublicQr || '';
            function showQR(containerId, data){
                var container = document.getElementById(containerId);
                container.innerHTML = '';
                new QRCode(container, { text: data, width: 240, height: 240 });
            }

            function showImageQR(containerId, url){
                var container = document.getElementById(containerId);
                // use onerror to fallback to public QR if storage image not found
                container.innerHTML = '<img src="'+url+'" alt="QR" style="max-width:240px; width:100%; height:auto;" onerror="this.onerror=null;this.src=\''+COMPANY_PUBLIC_QR+'\'">';
            }

            // Compra
            var pmCompra = document.getElementById('payment-method-compra');
            var cantidadInput = document.getElementById('cantidad-compra');
            function updateQRCompra(){
                var sel = pmCompra.options[pmCompra.selectedIndex];
                var qr = sel ? sel.dataset.qr : null;
                var codigo = sel ? sel.dataset.codigo : '';
                var cantidad = parseInt(cantidadInput.value) || 1;
                var monto = (PRODUCT_PRICE * cantidad).toFixed(2);
                document.getElementById('qr-message-compra').style.display = 'none';
                document.getElementById('qr-message-compra').innerText = '';
                document.getElementById('bank-info-compra').style.display = 'none';
                if(!sel || !sel.value){
                    document.getElementById('qr-area-compra').style.display = 'none';
                    return;
                }

                if (sel.value === 'transferencia_bancaria') {
                    document.getElementById('qr-area-compra').style.display = 'none';
                    document.getElementById('bank-info-compra').style.display = '';
                    return;
                }

                if(qr && qr.trim() !== ''){
                    showImageQR('qr-container-compra', STORAGE_URL + '/' + qr);
                    document.getElementById('qr-area-compra').style.display = '';
                } else if (codigo && codigo.trim() !== '') {
                    var payload = 'WAYNA|'+codigo+'|'+monto+'|'+PRODUCT_SLUG;
                    showQR('qr-container-compra', payload);
                    document.getElementById('qr-area-compra').style.display = '';
                } else if (sel.value === 'wayna_qr'){
                    showImageQR('qr-container-compra', COMPANY_QR_URL);
                    document.getElementById('qr-area-compra').style.display = '';
                } else {
                    document.getElementById('qr-area-compra').style.display = 'none';
                    var msg = 'Este método no muestra un QR. Completa el pago directamente en la app o selecciona otro método.';
                    var mEl = document.getElementById('qr-message-compra');
                    mEl.innerText = msg;
                    mEl.style.display = '';
                }
            }
            if(pmCompra){ pmCompra.addEventListener('change', updateQRCompra); cantidadInput.addEventListener('input', updateQRCompra); }

            // Donación
            var pmDonar = document.getElementById('payment-method-donar');
            var montoDonar = document.getElementById('monto-donar');
            function updateQRDonar(){
                var sel = pmDonar.options[pmDonar.selectedIndex];
                var qr = sel ? sel.dataset.qr : null;
                var codigo = sel ? sel.dataset.codigo : '';
                var monto = parseFloat(montoDonar.value).toFixed(2) || '0.00';
                document.getElementById('qr-message-donar').style.display = 'none';
                document.getElementById('qr-message-donar').innerText = '';
                document.getElementById('bank-info-donar').style.display = 'none';
                if(!sel || !sel.value){
                    document.getElementById('qr-area-donar').style.display = 'none';
                    return;
                }

                if (sel.value === 'transferencia_bancaria') {
                    document.getElementById('qr-area-donar').style.display = 'none';
                    document.getElementById('bank-info-donar').style.display = '';
                    return;
                }

                if(qr && qr.trim() !== ''){
                    showImageQR('qr-container-donar', STORAGE_URL + '/' + qr);
                    document.getElementById('qr-area-donar').style.display = '';
                } else if (codigo && codigo.trim() !== '') {
                    var payload = 'WAYNA|'+codigo+'|'+monto+'|'+PRODUCT_SLUG;
                    showQR('qr-container-donar', payload);
                    document.getElementById('qr-area-donar').style.display = '';
                } else if (sel.value === 'wayna_qr'){
                    showImageQR('qr-container-donar', COMPANY_QR_URL);
                    document.getElementById('qr-area-donar').style.display = '';
                } else {
                    document.getElementById('qr-area-donar').style.display = 'none';
                    var msg = 'Este método no muestra un QR. Completa el pago directamente en la app o selecciona otro método.';
                    var mEl = document.getElementById('qr-message-donar');
                    mEl.innerText = msg;
                    mEl.style.display = '';
                }
            }
            if(pmDonar){ pmDonar.addEventListener('change', updateQRDonar); montoDonar.addEventListener('input', updateQRDonar); }

            // initialize on load so a QR is visible immediately
            document.addEventListener('DOMContentLoaded', function(){
                try{ if(pmCompra) updateQRCompra(); }catch(e){}
                try{ if(pmDonar) updateQRDonar(); }catch(e){}
            });
        })();
    </script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LEONARDO\Desktop\wayna\LOS-BESTIES-Wolf-tank-wayna\wayna_mercado\resources\views/productos/show.blade.php ENDPATH**/ ?>