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
            <?php if (isset($cartItems) && is_array($cartItems) && !empty($cartItems)): ?>
                <?php foreach ($cartItems as $index => $item): ?>
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
            <?php else: ?>
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
                <div id="additionalPaymentFields">
                    <div id="cardPaymentFields" style="display: none;">
                        <h6 class="mt-3">Pago con Tarjeta</h6>
                        <form id="cardPaymentForm">
                            <div class="mb-3">
                                <label for="cardNumber" class="form-label">Número de Tarjeta</label>
                                <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required pattern="\d{4} \d{4} \d{4} \d{4}">
                            </div>
                            <div class="mb-3">
                                <label for="cardExpiry" class="form-label">Fecha de Expiración</label>
                                <input type="text" class="form-control" id="cardExpiry" placeholder="MM/AA" required pattern="\d{2}/\d{2}">
                            </div>
                            <div class="mb-3">
                                <label for="cardCVV" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cardCVV" placeholder="123" required pattern="\d{3}">
                            </div>
                        </form>
                    </div>

                    <div id="mercadoPagoFields" style="display: none;">
                        <h6 class="mt-3">Pago con Mercado Pago</h6>
                        <form id="mercadoPagoForm">
                            <div class="mb-3">
                                <label for="mercadoPagoEmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="mercadoPagoEmail" placeholder="tu-email@example.com" required>
                            </div>
                        </form>
                    </div>

                    <div id="transferPaymentFields" style="display: none;">
                        <h6 class="mt-3">Pago por Transferencia</h6>
                        <form id="transferForm">
                            <div class="mb-3">
                                <label for="transferAccount" class="form-label">Cuenta de Transferencia</label>
                                <input type="text" class="form-control" id="transferAccount" placeholder="Número de cuenta" required>
                            </div>
                            <div class="mb-3">
                                <label for="transferAmount" class="form-label">Monto Transferido</label>
                                <input type="text" class="form-control" id="transferAmount" placeholder="Monto transferido" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="confirmOrderButton" class="btn btn-primary">Confirmar Orden</button>
            </div>
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
                <div id="additionalPaymentFields">
                    <div id="cardPaymentFields" style="display: none;">
                        <h6 class="mt-3">Pago con Tarjeta</h6>
                        <form id="cardPaymentForm">
                            <div class="mb-3">
                                <label for="cardNumber" class="form-label">Número de Tarjeta</label>
                                <input type="text" class="form-control" id="cardNumber" placeholder="1234 5678 9012 3456" required pattern="\d{4} \d{4} \d{4} \d{4}">
                            </div>
                            <div class="mb-3">
                                <label for="cardExpiry" class="form-label">Fecha de Expiración</label>
                                <input type="text" class="form-control" id="cardExpiry" placeholder="MM/AA" required pattern="\d{2}/\d{2}">
                            </div>
                            <div class="mb-3">
                                <label for="cardCVV" class="form-label">CVV</label>
                                <input type="text" class="form-control" id="cardCVV" placeholder="123" required pattern="\d{3}">
                            </div>
                        </form>
                    </div>

                    <div id="mercadoPagoFields" style="display: none;">
                        <h6 class="mt-3">Pago con Mercado Pago</h6>
                        <form id="mercadoPagoForm">
                            <div class="mb-3">
                                <label for="mercadoPagoEmail" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="mercadoPagoEmail" placeholder="tu-email@example.com" required>
                            </div>
                        </form>
                    </div>

                    <div id="transferPaymentFields" style="display: none;">
                        <h6 class="mt-3">Pago por Transferencia</h6>
                        <form id="transferForm">
                            <div class="mb-3">
                                <label for="transferAccount" class="form-label">Cuenta de Transferencia</label>
                                <input type="text" class="form-control" id="transferAccount" placeholder="Número de cuenta" required>
                            </div>
                            <div class="mb-3">
                                <label for="transferAmount" class="form-label">Monto Transferido</label>
                                <input type="text" class="form-control" id="transferAmount" placeholder="Monto transferido" required>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="confirmOrderButton" class="btn btn-primary">Confirmar Orden</button>
            </div>
        </div>
    </div>
</div>

<!-- Scripts JS -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const paymentCash = document.getElementById('paymentCash');
        const paymentCard = document.getElementById('paymentCard');
        const paymentMercadoPago = document.getElementById('paymentMercadoPago');
        const paymentTransfer = document.getElementById('paymentTransfer');
        const deliveryAddress = document.getElementById('deliveryAddress');
        const pickupStore = document.getElementById('pickupStore');
        const addressInput = document.getElementById('addressInput');
        
        const cardPaymentFields = document.getElementById('cardPaymentFields');
        const mercadoPagoFields = document.getElementById('mercadoPagoFields');
        const transferPaymentFields = document.getElementById('transferPaymentFields');

        function updatePaymentFields() {
            if (paymentCash.checked) {
                cardPaymentFields.style.display = 'none';
                mercadoPagoFields.style.display = 'none';
                transferPaymentFields.style.display = 'none';
            } else if (paymentCard.checked) {
                cardPaymentFields.style.display = 'block';
                mercadoPagoFields.style.display = 'none';
                transferPaymentFields.style.display = 'none';
            } else if (paymentMercadoPago.checked) {
                cardPaymentFields.style.display = 'none';
                mercadoPagoFields.style.display = 'block';
                transferPaymentFields.style.display = 'none';
            } else if (paymentTransfer.checked) {
                cardPaymentFields.style.display = 'none';
                mercadoPagoFields.style.display = 'none';
                transferPaymentFields.style.display = 'block';
            }
        }

        function updateAddressField() {
            if (deliveryAddress.checked) {
                addressInput.style.display = 'block';
            } else {
                addressInput.style.display = 'none';
            }
        }

        paymentCash.addEventListener('change', updatePaymentFields);
        paymentCard.addEventListener('change', updatePaymentFields);
        paymentMercadoPago.addEventListener('change', updatePaymentFields);
        paymentTransfer.addEventListener('change', updatePaymentFields);

        deliveryAddress.addEventListener('change', updateAddressField);
        pickupStore.addEventListener('change', updateAddressField);

        document.getElementById('confirmOrderButton').addEventListener('click', function () {
            const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;
            const deliveryMethod = document.querySelector('input[name="deliveryMethod"]:checked').value;
            const address = document.getElementById('address').value;
            
            fetch("<?= base_url('verificar_carrito'); ?>")
                .then(response => response.json())
                .then(data => {
                    if (data.hasItems) {
                        // Aquí se deben enviar los datos de la venta
                        document.querySelector('form[action="<?= base_url('registrar_venta'); ?>"]').submit();
                    } else {
                        alert('El carrito está vacío.');
                    }
                });
        });

        // Inicializar el estado de los campos adicionales
        updatePaymentFields();
        updateAddressField();
    });
</script>
