<form action="<?= base_url('/alta_producto') ?>" method="post" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="form-group">
        <label for="nombre">Nombre del Producto:</label>
        <input type="text" class="form-control" name="nombre" id="nombre" value="<?= set_value('nombre') ?>">
    </div>
    <div class="form-group">
        <label for="precio">Precio:</label>
        <input type="text" class="form-control" name="precio" id="precio" value="<?= set_value('precio') ?>">
    </div>
    <div class="form-group">
        <label for="stock">Stock:</label>
        <input type="text" class="form-control" name="stock" id="stock" value="<?= set_value('stock') ?>">
    </div>
    <div class="form-group">
        <label for="categoria">Categoría:</label>
        <select class="form-control" name="categoria" id="categoria">
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['id'] ?>"><?= $categoria['nombre_categoria'] ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="imagen">Imagen del Producto:</label>
        <input type="file" class="form-control" name="imagen" id="imagen">
    </div>
    <button type="submit" class="btn btn-primary">Crear Producto</button>
</form>
