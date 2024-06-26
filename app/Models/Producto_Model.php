<?php
namespace App\Models;
use CodeIgniter\Model;

class Producto_Model extends Model 

{
    protected $table = 'productos';
    protected $primaryKey = 'id_producto';
    protected $allowedFields =
    ['nombre_producto', 
    'imagen_producto',
    'id_categoria',
    'precio_producto', 
    'marca_producto',
    'descripcion_producto',
    'stock_producto',
    'eliminado_producto'];
    protected $returnType = 'array';

    public function getProductosAlta(){
        return $this->where('eliminado_producto', 'NO')->findAll();
    }

    public function getProductosBaja(){
        return $this->where('eliminado_producto', 'SI')->findAll();
    }

    public function getProductosTodos(){
        return $this->findAll();
    }

    public function getBuilderProductos(){
        $db = \Config\Database::connect();

        $builder = $db->table('products');
        $builder->select('*');
        $builder->join('categoria','categorias.id_categoria = productos.id_categoria');

        return $builder;
    }

    public function getProducto($id = null){

        $builder = $this->getBuilderProductos();
        $builder->where('productos.id_producto', $id);
        $query = $builder->get();

        return $query->getRowArray();
    }

    public function updateStock($id = null, $stock = null){

        $builder = $this->getBuilderProductos();
        $builder->where('productos.id_producto', $id);
        $builder->set('productos.stock_producto', $stock);
        $builder->update();
    }
}
