<div class="container my-0 mb-5 d-flex justify-content-center">
    <div class="card registro" style="border-color: green; color: white; text-shadow: none; backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.5);">
        <div class="card-header text-center">
            <h2 style="color: green;">Alta Categoría</h2>
        </div>

        <?php $validation = \Config\Services::validation(); ?>

        <form method="post" action="<?php echo base_url('enviar-categoria') ?>">
            <?php if(!empty(session()->getFlashdata('error'))):?>
                <div class="alert alert-danger"><?= session()->getFlashdata('error'); ?></div>
            <?php endif?>
            <?php if(!empty(session()->getFlashdata('exito'))):?>
                <div class="alert alert-success"><?= session()->getFlashdata('exito'); ?></div>
            <?php endif?>

            <div class="card-body justify-content-center">
                <div class="form-floating">
                    <input name="descripcion_categoria" type="text" class="form-control" value="<?php echo isset($_POST['descripcion_categoria']) ? $_POST['descripcion_categoria'] : ''; ?>" placeholder="Ingrese la descripción de la categoría">
                    <label style="color: green;" for="descripcion_categoria" class="form-label">Descripción de la Categoría</label>

                    <?php if($validation->getError('descripcion_categoria')) {?>
                        <div class="py-1 alert alert-danger my-0" style="color: red; text-shadow: none;">
                            <?= $validation->getError('descripcion_categoria'); ?>
                        </div>
                    <?php }?>
                    <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2" style="color: black;">Entre 3 y 100 letras.</div>
                </div>
                
                <div class="mb-3">
                    <div class="form-check">
                        <input name="activo_categoria" type="checkbox" class="form-check-input" id="activo_categoria" value="SI" <?php echo isset($_POST['activo_categoria']) && $_POST['activo_categoria'] == 'SI' ? 'checked' : ''; ?>>
                        <label class="form-check-label" style="color: green;" for="activo_categoria">Activo</label>
                    </div>
                </div>

                <div class="container text-center">
                    <input type="submit" value="Enviar" class="btn btn-primary">
                    <a href="<?php echo base_url('gestion-categorias'); ?>" class="btn btn-danger">Atrás</a>
                    <script>
                        function borrarCampos() {
                            // Limpiar todos los campos de entrada de texto
                            document.querySelector('input[name="descripcion_categoria"]').value = '';

                            // Limpiar el campo de selección
                            document.querySelector('input[name="activo_categoria"]').checked = false;

                            // Limpiar cualquier mensaje de error
                            document.querySelectorAll('.alert-danger').forEach(alert => alert.remove());
                        }
                    </script>
                    <input type="button" value="Borrar" class="btn btn-secondary" onclick="borrarCampos()">
                </div>
            </div>
        </form>
    </div>
</div>