<?php
namespace App\Models;
use CodeIgniter\Model;

class Categoria_Model extends Model {
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $allowedFields =
    ['descripcion_categoria', 
    'activo_categoria'];
    protected $returnType = 'array';

    public function getCategorias() {
        return $this->findAll(); // O cualquier otro método que retorne las categorías
    }

}