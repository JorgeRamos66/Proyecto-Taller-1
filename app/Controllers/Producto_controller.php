<?php
namespace App\Controllers;
use App\Models\Producto_Model;
use App\Models\Usuario_Model;
use App\Models\Categoria_Model;
use Codeigniter\Controller;

class Producto_controller extends Controller{
    public function __construct(){
        helper(['url', 'form']);
        $session = session();
    }

    public function listar_productos(){

        $productoModel = new Producto_Model();
        

        $data['productos'] = $productoModel->getProductosTodos();

        $data['titulo'] = 'Productos';
        return view('proyecto/front/Encabezado')
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/Gestion_productos', $data)
        .view('proyecto/front/Pie_de_pagina');

    }

    public function crear_producto(){
        $categoriasModel = new Categoria_Model();
        $data
    }
}