<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('perfil_id');
$id = $session->get('id_usuario');
?>
<?php if (session()->getFlashdata('mensaje')): ?>
    <div class="container col-4 alert alert-success text-center fs-6 alert-dismissible fade show" role="alert">
        <?= session()->getFlashdata('mensaje') ?>
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
<?php endif;?>
<div class="comercializacion container mt-5" style="text-shadow: none; border-radius: 10px;background-color: rgb(255, 255, 255, 0)">
    <div style="text-align: center;">
        <h1 class="my-2 badge" style="text-shadow: none;color: blue;backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">Carrito de Compras</h1>
    </div>
    
    <table class="table table-success table-hover table-striped table-bordered align-middle text-center">
        <thead class="thead-dark">
            <tr class="align-middle">
                <th>Nombre del producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            // Inicializa el total del carrito
            $total_carrito = 0; 
            ?>
            <?php foreach ($cart as $index => $item): ?>
                <?php 
                // Calcula el subtotal por producto
                $subtotal = $item['price'] * $item['qty']; 
                // Suma el subtotal al total del carrito
                $total_carrito += $subtotal; 
                ?>
                <tr>
                    <td><?= esc($item['name']); ?></td>
                    <td>$<?= number_format($item['price'], 2); ?></td>
                    <td>
                        <div class="btn-group">
                            <form action="<?= base_url('incrementar_producto/' . $index); ?>" method="post" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-outline-dark">+</button>
                            </form>
                            <div class="btn btn-sm btn-dark">
                                <?= esc($item['qty']); ?>
                            </div>
                            
                            <form action="<?= base_url('decrementar_producto/' . $index); ?>" method="post" class="d-inline">
                                <button type="submit" class="btn btn-sm btn-outline-dark">-</button>
                            </form>
                        </div>
                        
                    </td>
                    <td>$<?= number_format($subtotal, 2); ?></td>
                    <td>
                        <form action="<?= base_url('quitar_producto/' . $index); ?>" method="post" class="d-inline">
                            <button type="submit" class="btn btn-sm btn-outline-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($cart)): ?>
                <tr>
                    <td colspan="5" class="text-center">No hay productos en el carrito.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="row">
        <div class="col-12 text-right">
            <h4 style="text-align: center;"><h1 class="my-2 badge" style="color: black;backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.8);">Total: $<?= number_format($total_carrito, 2); ?></h4>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12 text-center">
            
            <form action="<?= base_url('registrar_venta'); ?>" method="post" class="d-inline">
                <!-- Botón que abre el modal -->
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#paymentModal">
                    Confirmar Orden
                </button>
            </form>
            <form action="<?= base_url('vaciar_carrito'); ?>" method="post" class="d-inline">
                <button type="submit" class="btn btn-danger">Vaciar Carrito</button>
            </form>
            <a href="<?= base_url('catalogoDeProductos'); ?>" class="btn btn-primary">Seguir Comprando</a>
        </div>
    </div>
</div>
<!-- Modal para seleccionar pago y envío -->
<div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="paymentModalLabel">Seleccionar Método de Pago y Envío</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Sección de pago -->
                <h6>Seleccione el método de pago:</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCash" value="cash" checked>
                    <label class="form-check-label" for="paymentCash">
                        Contado
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="paymentCard" value="card">
                    <label class="form-check-label" for="paymentCard">
                        Tarjeta
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="paymentMercadoPago" value="mercado_pago">
                    <label class="form-check-label" for="paymentMercadoPago">
                        Mercado Pago
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="paymentMethod" id="paymentTransfer" value="transfer">
                    <label class="form-check-label" for="paymentTransfer">
                        Transferencia
                    </label>
                </div>
                
                <!-- Sección de envío -->
                <h6 class="mt-3">Seleccione el método de envío:</h6>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="deliveryMethod" id="pickupStore" value="pickup" checked>
                    <label class="form-check-label" for="pickupStore">
                        Retirar en sucursal
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="deliveryMethod" id="deliveryAddress" value="delivery">
                    <label class="form-check-label" for="deliveryAddress">
                        Enviar a domicilio
                    </label>
                </div>

                <!-- Campo de dirección (solo visible si se elige envío a domicilio) -->
                <div class="mt-2" id="addressInput" style="display: none;">
                    <label for="address">Dirección de envío:</label>
                    <input type="text" class="form-control" id="address" placeholder="Ingrese su dirección">
                </div>

                <!-- Sección de pago adicional (oculta por defecto) -->
                <div id="additionalPaymentFields" style="display: none;">
                    <div id="cardPaymentFields" style="display: none;">
                        <h6 class="mt-3">Pago con Tarjeta</h6>
                        <form id="cardPaymentForm">
                            <div class="mb-3">
                                <label for="cardNumber" class="form-label">Número de Tarjeta</label>
                                <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required pattern="\d{4} \d{4} \d{4} \d{4}">
                            </div>
                            <div class="mb-3">
                                <label for="cardExpiry" class="form-label">Fecha de Vencimiento</label>
                                <input type="text" class="form-control" id="cardExpiry" placeholder="MM/AA" required pattern="\d{2}/\d{2}">
                            </div>
                            <div class="mb-3">
                                <label for="cardCVC" class="form-label">Código de Seguridad</label>
                                <input type="text" class="form-control" id="cardCVC" placeholder="123" required pattern="\d{3}">
                            </div>
                        </form>
                    </div>
                    
                    <div id="transferPaymentFields" style="display: none;">
                        <h6 class="mt-3">Pago por Transferencia</h6>
                        <p>CBU: 12345678901</p>
                        <form id="transferPaymentForm">
                            <div class="mb-3">
                                <label for="transferReceipt" class="form-label">Adjuntar Comprobante de Transferencia (PDF)</label>
                                <input type="file" class="form-control" id="transferReceipt" accept=".pdf" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Atrás</button>
                <button type="button" class="btn btn-success" id="nextButton">Siguiente</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const addressInput = document.getElementById('addressInput');
        const deliveryAddress = document.getElementById('deliveryAddress');
        const nextButton = document.getElementById('nextButton');
        const confirmOrderButton = document.querySelector('button[data-bs-target="#paymentModal"]');

        deliveryAddress.addEventListener('change', function () {
            addressInput.style.display = 'block';
        });

        document.getElementById('pickupStore').addEventListener('change', function () {
            addressInput.style.display = 'none';
        });

        nextButton.addEventListener('click', function () {
            const selectedPaymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            switch (selectedPaymentMethod) {
                case 'card':
                    showCardPaymentModal();
                    break;
                case 'mercado_pago':
                    window.location.href = 'https://www.mercadopago.com.ar/';
                    break;
                case 'transfer':
                    showTransferPaymentModal();
                    break;
                case 'cash':
                    confirmOrder('cash');
                    break;
            }
        });

        confirmOrderButton.addEventListener('click', function(event) {

            // Realiza una solicitud para verificar si el carrito está vacío
            fetch('<?php echo base_url('verificar_carrito'); ?>')
                .then(response => response.json())
                .then(data => {
                    if (data.empty) {
                        alert('No hay productos en el carrito para confirmar la orden.');
                    } else {
                        // Si el carrito no está vacío, muestra el modal
                        $('#paymentModal').modal('show');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al verificar el estado del carrito.');
                });
        });

        function showCardPaymentModal() {
            $('#paymentModal').modal('hide');
            $('#cardPaymentModal').modal('show');
        }

        function showTransferPaymentModal() {
            $('#paymentModal').modal('hide');
            $('#transferPaymentModal').modal('show');
        }

        function confirmOrder(paymentMethod) {
            const formData = new FormData();
            formData.append('deliveryMethod', document.querySelector('input[name="deliveryMethod"]:checked').value);
            formData.append('address', document.getElementById('address').value);
            formData.append('paymentMethod', paymentMethod);

            // Validación para el método de pago con tarjeta
            if (paymentMethod === 'card') {
                const cardNumber = document.getElementById('cardNumber').value;
                const cardExpiry = document.getElementById('cardExpiry').value;
                const cardCVC = document.getElementById('cardCVC').value;

                if (!cardNumber || !cardExpiry || !cardCVC) {
                    alert('Por favor complete todos los campos de la tarjeta.');
                    return;
                }

                formData.append('cardNumber', cardNumber);
                formData.append('cardExpiry', cardExpiry);
                formData.append('cardCVC', cardCVC);
            } else if (paymentMethod === 'transfer') {
                const transferReceipt = document.getElementById('transferReceipt').files[0];
                if (transferReceipt) {
                    formData.append('transferReceipt', transferReceipt);
                } else {
                    alert('Por favor adjunte el comprobante de transferencia.');
                    return;
                }
            }

            fetch('<?php echo base_url('registrar_venta'); ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Orden confirmada exitosamente.');
                    window.location.href = '<?php echo base_url('catalogoDeProductos'); ?>';
                } else {
                    alert('Error al confirmar la orden: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error en la confirmación de la orden.');
            });
        }
    });
</script>