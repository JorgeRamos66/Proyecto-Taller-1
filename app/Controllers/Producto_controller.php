<?php
namespace App\Controllers;
use App\Models\Producto_Model;
use App\Models\Usuario_Model;
use App\Models\Categoria_Model;
use CodeIgniter\Controller;

class Producto_controller extends Controller{
    public function __construct(){
        helper(['url', 'form']);
        $session = session();
    }

    public function listar_productos(){

        $productoModel = new Producto_Model();
        
        $data['productos'] = $productoModel->getProductosTodos();
        $data['titulo'] = 'Gestion productos';

        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/Gestion_productos')
        .view('proyecto/front/Pie_de_pagina');

    }

    public function crear_producto(){
        $categoriasModel = new Categoria_Model();
        $data;
    }
}