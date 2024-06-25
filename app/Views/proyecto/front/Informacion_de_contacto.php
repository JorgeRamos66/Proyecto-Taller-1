<?php
$session = session();
$nombre = $session->get('nombre');
$perfil = $session->get('perfil_id');
?>

<?php $validation = \Config\Services::validation(); ?>
<section class="contacto text-justify">
    <div style="text-align: center;"><h1 class="my-2 badge" style="border-color: red ;color: red ;backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">Información de Contacto</h1></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="row-4">
                    <div class="informacion-empresa rounded-2 my-2 text-justify text-wrap" style="backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">
                        <div class="container">                        
                            <h3 class="py-2">Datos de la Empresa</h3>
                            <ul>
                                <li>
                                    <h4>Titular:</h4>
                                    <p>Jorge Ramos</p>
                                </li>
                                <li>
                                    <h4>Razón Social:</h4>
                                    <p>Ratita Sporting S.A</p>
                                </li>
                                <li>
                                    <h4>Domicilio Legal:</h4>
                                    <p>9 de Julio 1449, W3400 AZB Corrientes Capital</p>
                                    </li>
                                <li>
                                    <h4>Teléfonos:</h4>
                                    <p>03794473930</p>
                                </li>
                                <li>
                                    <h4>Correo Electrónico:</h4>
                                    <p>jorge.ramos.m588@gmail.com</p>
                                </li>
                                <li>
                                <h4>Redes Sociales:</h4>
                                <ul>
                                    <div class="row-fluid">
                                        <a href="https://web.facebook.com/" target="_blank"><img src="assets/img/facebookpng.png" width="40px" alt="Facebook"></a>
                                        <a href="https://web.instagram.com/" target="_blank"><img src="assets/img/instapng.png" width="40px" alt="Instagram"></a>
                                        <a href="https://web.whatsapp.com/" target="_blank"><img src="assets/img/whatspng.png" width="40px" alt="Whatsapp"></a>
                                    </div>
                                </ul>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row-4">
                    <div class="mb-5 border shadow w-100">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d341.22256755404374!2d-58.83222906691792!3d-27.466550269425948!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94456ca6d24ec0c9%3A0xb92ce3fedb0d7729!2sFacultad%20de%20Ciencias%20Exactas%20y%20Naturales%20y%20Agrimensura!5e0!3m2!1ses!2sar!4v1713318780409!5m2!1ses!2sar" width="100%" height="300" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-8 container">
            <?php if(session()->getFlashdata('msj')):?>
                <div class=" d-flex mx-6 justify-content-center">
                    <div class="alert alert-info alert-dismissible fade show" style="color: black; text-shadow: none;" role="alert">
                        <?= session()->getFlashdata('msj')?>
                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>

            <?php endif;?>
                <?php if(!session()->has('loggedIn')): ?>
                    <div class="px-2 rounded-2 my-2 text-justify text-wrap" style="backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">
                        <h2 class="mb-4 text-center py-2">Envíanos un Mensaje</h2>
                        <form class="my-0" method="post" action="<?php echo base_url('enviar_consulta/'. '1') ?>">
                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo isset($_POST['nombre']) ? $_POST['nombre'] : ''; ?>" placeholder="Maximo 25 caracteres."><br>
                                <?php if($validation->getError('nombre')) {?>
                                    <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                                        <?= $error = $validation->getError('nombre'); ?>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="mb-3">
                                <label for="apellido" class="form-label">Apellido</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" value="<?php echo isset($_POST['apellido']) ? $_POST['apellido'] : ''; ?>" placeholder="Maximo 25 caracteres."><br>
                                <?php if($validation->getError('apellido')) {?>
                                    <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                                        <?= $error = $validation->getError('apellido'); ?>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>" placeholder="nombre@ejemplo.com"><br>
                                <?php if($validation->getError('email')) {?>
                                    <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                                        <?= $error = $validation->getError('email'); ?>
                                    </div>
                                <?php }?>
                            </div>
                            <div class="mb-3">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <input type="text" class="form-control" id="mensaje" name="mensaje" value="<?php echo isset($_POST['mensaje']) ? $_POST['mensaje'] : ''; ?>" placeholder="Maximo 500 caracteres."></input><br>
                                <?php if($validation->getError('mensaje')) {?>
                                    <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                                        <?= $error = $validation->getError('mensaje'); ?>
                                    </div>
                                <?php }?>
                            </div>
                            <button type="submit" value="Enviar" class="btn btn-dark mb-2 mx-auto">Enviar</button>
                        </form>
                    </div>
                <?php else: ?>

                
                <div class="px-2 rounded-2 my-2 text-justify text-wrap" style="backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.2);">
                    <h2 class="mb-4 text-center">Envíanos un Mensaje</h2>
                    <form class="my-0" action="<?php echo base_url('enviar_consulta/'. '2') ?>" method="post">
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo session('nombre'); ?>" placeholder="Maximo 25 caracteres." disabled><br>
                            <input type="hidden" name="nombre" value="<?php echo session('nombre'); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="apellido" class="form-label">Apellido</label>
                            <input type="text" class="form-control" id="apellido" name="nombre" value="<?php echo session('apellido'); ?>" placeholder="Maximo 25 caracteres." disabled><br>
                            <input type="hidden" name="apellido" value="<?php echo session('apellido'); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo session('email'); ?>" placeholder="nombre@ejemplo.com" disabled><br>
                            <input type="hidden" name="email" value="<?php echo session('email'); ?>">
                        </div>
                        <div class="mb-3">
                            <label for="mensaje" class="form-label">Mensaje</label>
                            <input class="form-control" id="mensaje" name="mensaje" rows="4" placeholder="Maximo 500 caracteres."></input><br>
                            <?php if($validation->getError('mensaje')) {?>
                                <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                                    <?= $error = $validation->getError('mensaje'); ?>
                                </div>
                            <?php }?>
                        </div>
                        <div class="text-center"><button type="submit" value="Enviar" class="btn btn-dark mb-2 mx-auto ">Enviar</button></div>
                        
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
  </section>