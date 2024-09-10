<?php
namespace App\Models;
use CodeIgniter\Model;

class Venta_Detalle_Model extends Model {
    protected $table = 'ventas_detalle';
    protected $primaryKey = 'id_ventas_detalle';
    protected $allowedFields =
    ['venta_id', 
    'producto_id',
    'cantidad',
    'precio'];
    protected $returnType = 'array';

    public function getDetalles($id = null) {
        $db = \Config\Database::connect();
        $builder = $db->table('ventas_detalle');
        $builder->select('ventas_detalle.*, productos.*, usuarios.nombre as nombre_usuario, usuarios.apellido as apellido_usuario');
        $builder->join('ventas_cabecera', 'ventas_cabecera.id_ventas_cabecera = ventas_detalle.venta_id');
        $builder->join('productos', 'productos.id_producto = ventas_detalle.producto_id');
        $builder->join('usuarios', 'usuarios.id_usuario = ventas_cabecera.usuario_id');
        if ($id != null) {
            $builder->where('ventas_cabecera.id_ventas_cabecera', $id);
        }
        $query = $builder->get();
        return $query->getResultArray();
    }

}