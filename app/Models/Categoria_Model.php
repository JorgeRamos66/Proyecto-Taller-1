<?php
namespace App\Models;
use CodeIgniter\Model;

class Categoria_Model extends Model {
    protected $table = 'categorias';
    protected $primaryKey = 'id_categoria';
    protected $allowedFields =
    ['descripcion_categoria', 
    'activocategoria'];
    protected $returnType = 'array';
}