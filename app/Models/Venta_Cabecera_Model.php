<?php
namespace App\Models;
use CodeIgniter\Model;

class Venta_Cabecera_Model extends Model {
    protected $table = 'ventas_cabecera';
    protected $primaryKey = 'id_ventas_cabecera';
    protected $allowedFields =
    ['fecha', 
    'usuario_id',
    'total_venta'];
    protected $returnType = 'array';

    public function getVentaConUsuario($id) {
        return $this->select('ventas_cabecera.*, usuarios.nombre as nombre_usuario, usuarios.apellido as apellido_usuario')
                    ->join('usuarios', 'usuarios.id_usuario = ventas_cabecera.usuario_id')
                    ->find($id);
    }
}