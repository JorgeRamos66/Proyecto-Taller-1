<?php if(session()->getFlashdata('exito')):?>
<div class=" d-flex mx-6 justify-content-center">
  <div class="alert alert-succes alert-dismissible fade show" style="color: black; text-shadow: none;" role="alert">
    <?= session()->getFlashdata('exito')?>
    <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
</div>
<?php endif;?>
<div class="container mt-2 mb-5 d-flex justify-content-center">
    <div class="card registro" style="border-color: green; color: white ;text-shadow: none; ;backdrop-filter: blur(10px); background-color: rgb(255, 255, 255, 0.5);">
      <div class="card-header text-center">
        <h2 style="color: green;">Alta Producto</h2>
      </div>
            
      <?php $validation = \Config\Services::validation(); ?>
     
      <form method="post" action="<?php echo base_url('enviar-producto') ?>">
        <?php if(!empty (session()->getFlashdata('error'))):?>
            <div class="alert alert-danger"><?=session()->getFlashdata('error');?></div>
        <?php endif?>
        <?php if(!empty (session()->getFlashdata('exito'))):?>
            <div class="alert alert-danger"><?=session()->getFlashdata('exito');?></div>
        <?php endif?>    	
        <div class ="card-body justify-content-center" media="(max-width:768px)">
            <div class="form-floating">
                <input name="nombre_producto" type="text"  class="form-control" value="<?php echo isset($_POST['nombre_producto']) ? $_POST['nombre_producto'] : ''; ?>" placeholder="Ingrese su nombre" >
                <label style="color: green;" for="nombre_usuario" class="form-label">Producto</label>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 25 letras.</div>
                <!-- Error -->
                    <?php if($validation->getError('nombre_producto')) {?>
                        <div class="py-1 alert alert-danger mt-2" style="color: red; text-shadow: none;">      
                            <?= $error = $validation->getError('nombre_producto'); ?>
                        </div>
                    <?php }?>
            </div>          
            <select style="color: green;" class="mb-1 form-floating form-control" name="id_categoria" id="categoria">
                <option value="">Seleccionar Categoria</option>
                <?php foreach ($categorias as $categoria): ?>
                    <option value="<?= $categoria['id_categoria'] ?>"><?= $categoria['descripcion_categoria'] ?></option>
                <?php endforeach; ?>
                <?php if($validation->getError('id_categoria')) {?>
                  <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                    <?= $error = $validation->getError('id_categoria'); ?>
                  </div>
                <?php }?>
            </select>
            <div id="nameHelp" class="form-text fw-medium text mt-0 mb-3">Seleccione una categoria.</div>
        
          
            <div class="mb-3 form-floating">
                <input name="precio_producto" type="text"  class="form-control" value="<?php echo isset($_POST['precio_producto']) ? $_POST['precio_producto'] : ''; ?>" placeholder="Ingrese su nombre" >
                <label style="color: green;" for="precio_producto" class="form-label">Precio</label>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 25 letras.</div>
                <!-- Error -->
                    <?php if($validation->getError('precio_producto')) {?>
                        <div class="py-1 alert alert-danger mt-2" style="color: red; text-shadow: none;">      
                        <?= $error = $validation->getError('precio_producto'); ?>
                        </div>
                    <?php }?>
            </div>   
            <div class="mb-3 form-floating">
                <input  type="text" name="precio_vta_producto" class="form-control" value="<?php echo isset($_POST['precio_vta_producto']) ? $_POST['precio_vta_producto'] : ''; ?>" placeholder="Ingrese un nombre de usuario">
                <label style="color: green;" for="precio_vta_producto" class="form-label">Precio de venta</label>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 25 letras.</div>
                <!-- Error -->
                <?php if($validation->getError('precio_vta_producto')) {?>
                    <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                    <?= $error = $validation->getError('precio_vta_producto'); ?>
                    </div>
                <?php }?>
            </div>
          
            <div class="mb-3 form-floating">
                <input name="stock_producto" type="text" class="form-control" value="<?php echo isset($_POST['stock_producto']) ? $_POST['stock_producto'] : ''; ?>" placeholder="Contraseña">
                <label style="color: green;" for="exampleFormControlInput1" class="form-label">Stock</label>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 10 letras.</div>
                <!-- Error -->
                <?php if($validation->getError('stock_producto')) {?>
                    <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                    <?= $error = $validation->getError('stock_producto'); ?>
                    </div>
                <?php }?>
            </div>
            <div class="mb-3 form-floating">
                <input name="stock_min_producto" type="text" class="form-control" value="<?php echo isset($_POST['stock_min_producto']) ? $_POST['stock_min_producto'] : ''; ?>" placeholder="Repita la contraseña">
                <label style="color: green;" for="exampleFormControlInput1" class="form-label">Stock minimo</label>
                <div id="nameHelp" class="form-text fw-medium text mt-0 mb-2">Entre 3 y 10 letras.</div>
                <!-- Error -->
                <?php if($validation->getError('stock_min_producto')) {?>
                    <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                    <?= $error = $validation->getError('stock_min_producto'); ?>
                    </div>
                <?php }?>
            </div>
            <div class="mb-3 file">
                <label style="color: green;" for="imagen">Imagen del Producto:</label>
                <input type="file" class="form-control" name="imagen" id="imagen">
                <?php if($validation->getError('imagen')) {?>
                    <div class='py-1 alert alert-danger mt-2' style="color: red; text-shadow: none;">
                    <?= $error = $validation->getError('imagen'); ?>
                    </div>
                <?php }?>
            </div>
            
            
            <div class="container text-center">
                <input type="submit" value="Enviar" class="btn btn-primary">
                <a href="<?php echo base_url('gestion_productos'); ?>" class="btn btn-danger">Atras</a>
                <input type="reset" value="Borrar" class="btn btn-secondary" onclick="borrarTextArea()">
            </div>
            
        </div>
      </form>
    </div>
  </div>

