<?php
namespace App\Models;
use CodeIgniter\Model;

class Consulta_Model extends Model {
    protected $table = 'consultas';
    protected $primaryKey = 'id_consulta';
    protected $allowedFields =
    ['consulta_nombre', 
    'consulta_apellido',
    'consulta_email',
    'consulta_mensaje',
    'consulta_registrado',
    'consulta_leido'];
    protected $returnType = 'array';

    public function getMensajes() {
        return $this->findAll();
    }

    public function getMensajesLeidos() {
        return $this->where('consulta_leido', 'SI')->findAll();
    }

    public function getMensajesNoLeidos() {
        return $this->where('consulta_leido', 'NO')->findAll();
    }

}