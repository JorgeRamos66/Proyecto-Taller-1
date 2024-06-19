<?php
namespace App\Controllers;
use App\Models\Producto_Model;
use App\Models\Categoria_Model;
use CodeIgniter\Controller;

class Producto_controller extends Controller{
    public function __construct(){
        helper(['url', 'form']);
        $session = \Config\Services::session();
        //$session = session();
    }

    public function listar_productos(){

        $productoModel = new Producto_Model();
        $categoriasModel = new Categoria_Model();

        $data['categorias'] = $categoriasModel->getCategorias();
        $data['productos'] = $productoModel->getProductosTodos();
        $data['titulo'] = 'Gestion productos';

        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/Gestion_productos')
        .view('proyecto/front/Pie_de_pagina');

    }

    public function crear_producto(){
        $categoriasModel = new Categoria_Model();
        $productoModel = new Producto_Model();
        $data['categorias'] = $categoriasModel->getCategorias();
        $data['obj'] = $productoModel->orderBy('id_producto', 'DESC')->findAll();
        
        $data['titulo'] = 'Alta Producto';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/Alta_producto')
        .view('proyecto/front/Pie_de_pagina'); 

    }

    public function store(){
        $session = session();
        $categoriasModel = new Categoria_Model();

        $input = $this->validate([
            'nombre_producto'       => 'required|min_length[3]',
            'id_categoria'          => 'required|is_not_unique[categorias.id_categoria]',
            'precio_producto'       => 'required',
            'precio_vta_producto'   => 'required',
            'stock_producto'        => 'required',
            'stock_min_producto'    => 'required',
            'imagen_producto'       => 'uploaded[imagen_producto]'
        ],
        [
            'nombre_producto'=>[
                'required'=>'Debe ingresar un nombre que tenga almenos 3 caracteres.',
                'min_length'=>'Debe tener minimo 3 caracteres.'
            ],
            'id_categoria'=>[
                'required'=>'Debe seleccionar alguna categoria.',
                'is_not_unique'=>'Seleccione una categoria existente.'
            ],
            'precio_producto'=>[
                'required'=>'Debe ingresar un precio para el producto.'
            ],
            'precio_vta_producto'=>[
                'required'=>'Debe ingresar un precio de venta para el producto.'
            ],
            'stock_producto'=>[
                'required'=>'Debe ingresar un stock inicial para el producto.'
            ],
            'stock_min_producto'=>[
                'required'=>'Debe ingresar un stock minimo para el producto.'
            ],
            'imagen_producto'=>[
                'uploaded'=>'Debe cargar una imagen.'
            ]
        ]
       );
    
       $productoModel = new Producto_Model();
       if (!$input) {
        $data['categorias'] = $categoriasModel->getCategorias();
        $data['titulo'] = 'Alta Producto';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/Alta_producto', ['validation' => $this->validator])
        .view('proyecto/front/Pie_de_pagina');

       }else {
        
        $img = $this->request->getFile('imagen_producto');
        $nombre_aleatorio = $img->getRandomName();
        $img->move(ROOTPATH. 'assets/uploads', $nombre_aleatorio);

        $data = [
            'nombre_producto'       => $this->request->getPost('nombre_producto'), 
            'imagen_producto'       => $nombre_aleatorio,
            'id_categoria'          => $this->request->getPost('id_categoria'),
            'precio_producto'       => $this->request->getPost('precio_producto'), 
            'precio_vta_producto'   => $this->request->getPost('precio_vta_producto'),
            'stock_producto'        => $this->request->getPost('stock_producto'),
            'stock_min_producto'    => $this->request->getPost('stock_min_producto'),
            'eliminado_producto'    => 'NO'
        ];

        $productoModel->insert($data);

        return redirect()->to(base_url('gestion_productos'))->with('exito', 'Producto agregado!');
        }

        
    }
}