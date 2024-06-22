<?php
namespace App\Controllers;
use App\Models\Producto_Model;
use App\Models\Categoria_Model;
use CodeIgniter\Controller;

class Producto_controller extends BaseController{
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
            'nombre_producto'       => 'required|min_length[3]|max_length[25]',
            'id_categoria'          => 'required|is_not_unique[categorias.id_categoria]',
            'precio_producto'       => 'required|numeric',
            'marca_producto'        => 'required|min_length[3]|max_length[25]',
            'descripcion_producto'  => 'required|min_length[3]|max_length[100]',
            'stock_producto'        => 'required|integer|greater_than[0]',
            'imagen_producto'       => 'uploaded[imagen_producto]|is_image[imagen_producto]'
        ],
        [
            'nombre_producto'=>[
                'required'   =>'Debe ingresar un nombre que tenga almenos 3 caracteres.',
                'min_length' =>'Debe tener minimo 3 caracteres.',
                'max_length' =>'Debe tener maximo 25 caracteres.'
            ],
            'id_categoria'      =>[
                'required'      =>'Debe seleccionar alguna categoria.',
                'is_not_unique' =>'Seleccione una categoria existente.'
            ],
            'precio_producto'=>[
                'required'   =>'Debe ingresar un precio para el producto.',
                'numeric'    =>'Debe ingresar un valor numerico.'
            ],
            'marca_producto'    =>[
                'required'      =>'Debe ingresar un precio de venta para el producto.',
                'min_length'    =>'Debe tener minimo 3 caracteres.',
                'max_length'    =>'Debe tener maximo 25 caracteres.'
            ],
            'descripcion_producto'=>[
                'required'        =>'Debe ingresar un stock inicial para el producto.',
                'min_length'      =>'Debe tener minimo 3 caracteres.',
                'max_length'      =>'Debe tener maximo 100 caracteres.'
            ],
            'stock_producto'    =>[
                'required'      =>'Debe ingresar un stock minimo para el producto.',
                'integer'       =>'Debe ingresar un numero entero.',
                'greater_than'  =>'Debe ingresar un numero mayor a 0.'
            ],
            'imagen_producto'=>[
                'uploaded'   =>'Debe cargar una imagen.',
                'is_image'   => 'El archivo cargado no es una imagen válida.'
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
            'marca_producto'        => $this->request->getPost('marca_producto'),
            'descripcion_producto'  => $this->request->getPost('descripcion_producto'),
            'stock_producto'        => $this->request->getPost('stock_producto'),
            'eliminado_producto'    => 'NO'
        ];

        $productoModel->insert($data);

        return redirect()->to(base_url('gestion_productos'))->with('agregado', 'Producto agregado!');
        }

    }
    public function eliminar_producto($id=null){
        $productoModel = new Producto_Model();
        $data['eliminado_producto'] = 'SI';
        $productoModel->update($id,$data);

        return redirect()->to(base_url('gestion_productos'))->with('eliminado', 'Producto dado de baja!');

    }
    public function activar_producto($id=null){
        $productoModel = new Producto_Model();
        $data['eliminado_producto'] = 'NO';
        $productoModel->update($id,$data);

        return redirect()->to(base_url('gestion_productos'))->with('activado', 'Producto dado de alta!');

    }
    public function editar_producto($id=null){
        $session = session();
        $categoriasModel = new Categoria_Model();

        $input = $this->validate([
            'nombre_producto'       => 'required|min_length[3]|max_length[25]',
            'id_categoria'          => 'required|is_not_unique[categorias.id_categoria]',
            'precio_producto'       => 'required|numeric',
            'marca_producto'        => 'required|min_length[3]|max_length[25]',
            'descripcion_producto'  => 'required|min_length[3]|max_length[100]',
            'stock_producto'        => 'required|integer|greater_than[0]',
            'imagen_producto'       => 'uploaded[imagen_producto]|is_image[imagen_producto]'
        ],
        [
            'nombre_producto'=>[
                'required'   =>'Debe ingresar un nombre que tenga almenos 3 caracteres.',
                'min_length' =>'Debe tener minimo 3 caracteres.',
                'max_length' =>'Debe tener maximo 25 caracteres.'
            ],
            'id_categoria'      =>[
                'required'      =>'Debe seleccionar alguna categoria.',
                'is_not_unique' =>'Seleccione una categoria existente.'
            ],
            'precio_producto'=>[
                'required'   =>'Debe ingresar un precio para el producto.',
                'numeric'    =>'Debe ingresar un valor numerico.'
            ],
            'marca_producto'    =>[
                'required'      =>'Debe ingresar un precio de venta para el producto.',
                'min_length'    =>'Debe tener minimo 3 caracteres.',
                'max_length'    =>'Debe tener maximo 25 caracteres.'
            ],
            'descripcion_producto'=>[
                'required'        =>'Debe ingresar un stock inicial para el producto.',
                'min_length'      =>'Debe tener minimo 3 caracteres.',
                'max_length'      =>'Debe tener maximo 100 caracteres.'
            ],
            'stock_producto'    =>[
                'required'      =>'Debe ingresar un stock minimo para el producto.',
                'integer'       =>'Debe ingresar un numero entero.',
                'greater_than'  =>'Debe ingresar un numero mayor a 0.'
            ],
            'imagen_producto'=>[
                'uploaded'   =>'Debe cargar una imagen.',
                'is_image'   => 'El archivo cargado no es una imagen válida.'
            ]
        ]
       );
    
       $productoModel = new Producto_Model();
       if (!$input) {
        $data['categorias'] = $categoriasModel->getCategorias();
        $data['titulo'] = 'Alta Producto';
        
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/editar-producto/'.$id, ['validation' => $this->validator])
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
            'marca_producto'        => $this->request->getPost('marca_producto'),
            'descripcion_producto'  => $this->request->getPost('descripcion_producto'),
            'stock_producto'        => $this->request->getPost('stock_producto'),
            'eliminado_producto'    => 'NO'
        ];

        $productoModel->insert($data);

        return redirect()->to(base_url('gestion_productos'))->with('editado', 'Producto actualizado!');
    }
}
    public function update(){
        $productoModel = new Producto_Model();

        return redirect()->to(base_url('gestion_productos'))->with('activado', 'Producto dado de alta!');
    }
    
}