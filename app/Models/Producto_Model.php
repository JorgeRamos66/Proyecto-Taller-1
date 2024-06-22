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
}
