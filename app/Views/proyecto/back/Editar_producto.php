
<div class="container mt-2 mb-5 d-flex justify-content-center">
    <div class="card registro" style="border-color: green; color: white ;text-shadow: none; ;backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.5);">
      <div class="card-header text-center">
        <h2 style="color: green;">Formulario de Edicion</h2>
      </div>
            
      <?php $validation = \Config\Services::validation(); ?>
     
      <form method="post" action="<?php echo base_url('actualizar-producto/'.$producto['id_producto']) ?>" enctype="multipart/form-data">
        <?php if(!empty (session()->getFlashdata('error'))):?>
            <div class="alert alert-danger"><?=session()->getFlashdata('error');?></div>
        <?php endif?>
        <?php if(!empty (session()->getFlashdata('exito'))):?>
            <div class="alert alert-danger"><?=session()->getFlashdata('exito');?></div>
        <?php endif?>
        <div class ="card-body justify-content-center" media="(max-width:768px)">
            
            <div class="form-floating">
                    <input name="nombre_producto" type="text"  class="form-control" value="<?php echo isset($_POST['nombre_producto']) ? $_POST['nombre_producto'] : $producto['nombre_producto'] ; ?>" placeholder="Ingrese su nombre" >
                    <label style="color: green;" for="nombre_usuario" class="form-label">Nombre del producto</label>
                    
                    <!-- Error -->
                    <?php if($validation->getError('nombre_producto')) {?>
                        <div class="py-1 alert alert-danger my-0" style="color: red; text-shadow: none;">      
                            <?= $error = $validation->getError('nombre_producto'); ?>
                        </div>
                    <?php }?>
                    <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2" style="color: black;">Entre 3 y 25 letras.</div>
                </div>
            
            <div>
            <?php
            // Obtener el id_categoria del producto a editar o establecer un valor por defecto
            $id_categoria_producto = isset($producto) ? $producto['id_categoria'] : null;
            ?>

            <select style="color: green;" class="mb-1 form-floating form-control" name="id_categoria" id="categoria">
                <option value="">Seleccionar Categoria</option>
                <?php foreach ($categorias as $categoria): ?>
                    <?php $selected = (isset($id_categoria_producto) && $id_categoria_producto == $categoria['id_categoria']) ? 'selected' : '' ; ?>
                    <option value="<?= $categoria['id_categoria'] ?>" <?= $selected ?>>
                        <?= $categoria['descripcion_categoria'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            
                <?php if($validation->getError('id_categoria')) {?>
                    <div class='py-1 alert alert-danger my-0' style="color: red; text-shadow: none;">
                        <?= $error = $validation->getError('id_categoria'); ?>
                    </div>
                <?php }?>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-3" style="color: black;">Seleccione una categoria.</div>
            </div>        
            
            
        
          
            <div class="mb-3 form-floating">
                <input name="precio_producto" type="text"  class="form-control" value="<?php echo isset($_POST['precio_producto']) ? $_POST['precio_producto'] : $producto['precio_producto']; ?>" placeholder="Ingrese su nombre" >
                <label style="color: green;" for="precio_producto" class="form-label mb-1">Precio</label>
                
                <!-- Error -->
                    <?php if($validation->getError('precio_producto')) {?>
                        <div class="py-1 alert alert-danger my-0" style="color: red; text-shadow: none;">      
                        <?= $error = $validation->getError('precio_producto'); ?>
                        </div>
                    <?php }?>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2" style="color: black;">Ingrese un numero.</div>
            </div>   
            <div class="mb-3 form-floating">
                <input  type="text" name="marca_producto" class="form-control" value="<?php echo isset($_POST['marca_producto']) ? $_POST['marca_producto'] : $producto['marca_producto']; ?>" placeholder="Ingrese un nombre de usuario">
                <label style="color: green;" for="marca_producto" class="form-label">Marca</label>
                
                <!-- Error -->
                <?php if($validation->getError('marca_producto')) {?>
                    <div class='py-1 alert alert-danger my-0' style="color: red; text-shadow: none;">
                    <?= $error = $validation->getError('marca_producto'); ?>
                    </div>
                <?php }?>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2" style="color: black;">Entre 3 y 25 letras.</div>
            </div>
          
            <div class="mb-3 form-floating">
                <input name="descripcion_producto" type="text" class="form-control" value="<?php echo isset($_POST['descripcion_producto']) ? $_POST['descripcion_producto'] : $producto['descripcion_producto']; ?>" placeholder="Contraseña">
                <label style="color: green;" for="exampleFormControlInput1" class="form-label">Descripcion</label>
                
                <!-- Error -->
                <?php if($validation->getError('descripcion_producto')) {?>
                    <div class='py-1 alert alert-danger my-0' style="color: red; text-shadow: none;">
                    <?= $error = $validation->getError('descripcion_producto'); ?>
                    </div>
                <?php }?>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2" style="color: black;">Entre 3 y 100 letras.</div>
            </div>
            <div class="mb-3 form-floating">
                <input name="stock_producto" type="text" class="form-control" value="<?php echo isset($_POST['stock_producto']) ? $_POST['stock_producto'] : $producto['stock_producto']; ?>" placeholder="Repita la contraseña">
                <label style="color: green;" for="exampleFormControlInput1" class="form-label">Stock</label>
                
                <!-- Error -->
                <?php if($validation->getError('stock_producto')) {?>
                    <div class='py-1 alert alert-danger my-0' style="color: red; text-shadow: none;">
                    <?= $error = $validation->getError('stock_producto'); ?>
                    </div>
                <?php }?>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2" style="color: black;">Ingrese un numero entero.</div>
            </div>
            <div class="mb-3 file">
                <label style="color: green;" for="imagen_producto">Imagen del Producto:</label>
                <input type="file" class="form-control" name="imagen_producto" id="imagen_producto">
                
                <?php if($validation->getError('imagen_producto')) {?>
                    <div class='py-1 alert alert-danger my-0' style="color: red; text-shadow: none;">
                    <?= $error = $validation->getError('imagen_producto'); ?>
                    </div>
                <?php }?>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2" style="color: black;">Solo archivos con formato de imagen.</div>
            </div>
            
            
            <div class="container text-center">
                <input type="submit" value="Actualizar" class="btn btn-success">
                <a href="<?php echo base_url('gestion_productos'); ?>" class="btn btn-danger">Atras</a>
                <script>
                    function borrarCampos() {
                        // Limpiar todos los campos de entrada de texto
                        document.querySelector('input[name="nombre_producto"]').value = '';
                        document.querySelector('input[name="precio_producto"]').value = '';
                        document.querySelector('input[name="marca_producto"]').value = '';
                        document.querySelector('input[name="descripcion_producto"]').value = '';
                        document.querySelector('input[name="stock_producto"]').value = '';
                        
                        // Limpiar el campo de selección
                        document.querySelector('select[name="id_categoria"]').selectedIndex = 0; // Selecciona el primer índice, que debe ser la opción "Seleccionar Categoria"

                        // Limpiar el campo de archivo
                        document.querySelector('input[name="imagen_producto"]').value = '';

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

