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

    public function getDetalles($id = null, $id_usuario = null){
        $db = \Config\Database::connect();
        $builder = $db->table('ventas_detalle');
        $builder->select('*');
        $builder->join('ventas_cabecera', 'ventas_cabecera.id_ventas_cabecera = ventas_detalle.venta_id');
        $builder->join('productos', 'productos.id_producto = ventas_detalle.producto_id');
        $builder->join('usuarios', 'usuarios.id_usuario = ventas_cabecera.usuario_id');
        if($id != null){
            // Correct usage assuming $id represents a column in ventas_cabecera table
            $builder->where('ventas_cabecera.id_ventas_cabecera', $id);
        }
        
        $query = $builder->get();
        return $query->getResultArray();
    }

}