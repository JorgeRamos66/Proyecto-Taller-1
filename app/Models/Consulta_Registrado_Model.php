<?php
namespace App\Models;
use CodeIgniter\Model;

class Consulta_Registrado_Model extends Model {
    protected $table = 'usuarios_consultas';
    protected $primaryKey = 'id_consulta_usuario';
    protected $allowedFields =
    ['usuario_consulta_nombre', 
    'usuario_consulta_apellido', 
    'usuario_consulta_email', 
    'usuario_consulta_mensaje', 
    'usuario_consulta_leido'];
    protected $returnType = 'array';

    public function getMensajesLeidos() {
        return $this->where('usuario_leido', 'SI')->findAll();
    }

    public function getMensajesNoLeidos() {
        return $this->where('usuario_leido', 'NO')->findAll();
    }
}