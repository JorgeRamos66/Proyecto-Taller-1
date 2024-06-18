<?php
namespace App\Models;
use CodeIgniter\Model;

class Usuario_Model extends Model

{
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';
    protected $allowedFields = 
    ['nombre',
    'apellido',
    'usuario',
    'email',
    'pass',
    'perfil_id'
    ,'baja',];
    protected $returnType = 'array';

    public function getUsuariosAlta(){
        return $this->where('baja', 'NO')->findAll();
    }

    public function getUsuariosBaja(){
        return $this->where('baja', 'SI')->findAll();
    }

    public function getUsuariosTodos(){
        return $this->findAll();
    }
}