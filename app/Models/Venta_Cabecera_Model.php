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

    
}