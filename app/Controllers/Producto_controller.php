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

    public function catalogo_productos() {
        $productoModel = new Producto_Model();
        $categoriaModel = new Categoria_Model();
    
        // Parámetros para la paginación y búsqueda
        $itemsPerPage = $this->request->getVar('itemsPerPage') ? $this->request->getVar('itemsPerPage') : 5;
        $search = $this->request->getGet('search');
    
        // Obtener productos con o sin filtro de búsqueda
        if ($search) {
            // Aplica la búsqueda y filtra productos no eliminados
            $productos = $productoModel->where('eliminado_producto', 'NO') // Filtra productos no eliminados
                                       ->groupStart()
                                       ->like('nombre_producto', $search)
                                       ->orLike('descripcion_producto', $search)
                                       ->orLike('marca_producto', $search)
                                       ->groupEnd()
                                       ->paginate($itemsPerPage, 'productos');
        } else {
            // Obtener solo productos no eliminados
            $productos = $productoModel->where('eliminado_producto', 'NO') // Filtra productos no eliminados
                                       ->paginate($itemsPerPage, 'productos');
        }
    
        $pager = $productoModel->pager;
        $pager->setPath('catalogo_productos'); // Establecer la ruta base para la paginación
    
        $data = [
            'categorias' => $categoriaModel->getCategorias(),
            'productos' => $productos,
            'pager' => $pager,
            'itemsPerPage' => $itemsPerPage,
            'search' => $search,
            'titulo' => 'Catálogo de Productos',
        ];
    
        return view('proyecto/front/Encabezado', $data)
               . view('proyecto/front/Barra_de_navegacion')
               . view('proyecto/front/Catalogo_productos', $data)
               . view('proyecto/front/Pie_de_pagina');
    }

    public function gestion_productos() {
        $productoModel = new Producto_Model();
    
        // Obtener el término de búsqueda y número de elementos por página
        $search = $this->request->getGet('search');
        $itemsPerPage = $this->request->getGet('itemsPerPage') ?? 5;
    
        // Aplicar filtro de búsqueda si existe
        if ($search) {
            // Busca en nombre o marca
            $productos = $productoModel->groupStart()
                                       ->like('nombre_producto', $search)
                                       ->orLike('descripcion_producto', $search)
                                       ->orLike('marca_producto', $search)
                                       ->groupEnd()
                                       ->paginate($itemsPerPage, 'productos');
        } else {
            $productos = $productoModel->paginate($itemsPerPage, 'productos');
        }
    
        $pager = $productoModel->pager;
        $pager->setPath('gestion_productos'); // Establece la ruta base para la paginación
    
        $data = [
            'productos' => $productos,
            'pager' => $pager,
            'itemsPerPage' => $itemsPerPage,
            'search' => $search
        ];
    
        return view('proyecto/front/Encabezado', $data)
            .view('proyecto/front/Barra_de_navegacion_admin')
            .view('proyecto/back/Gestion_productos', $data) // Pasa $data aquí
            .view('proyecto/front/Pie_de_pagina');
    }

    public function crear_producto(){
        $categoriasModel = new Categoria_Model();
        $productoModel = new Producto_Model();
        $data['categorias'] = $categoriasModel->getCategorias();
        
        $data['titulo'] = 'Alta Producto';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/Alta_producto')
        .view('proyecto/front/Pie_de_pagina');

    }

    public function store(){
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
        
        $categoriasModel = new Categoria_Model();
        $productoModel = new Producto_Model();
        $data['categorias'] = $categoriasModel->getCategorias();
        $data['producto'] = $productoModel->find($id);
        
        $data['titulo'] = 'Editar Producto';

        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/Editar_producto')
        .view('proyecto/front/Pie_de_pagina');
    }
    public function update($id=null){
        $productoModel = new Producto_Model();
        $categoriasModel = new Categoria_Model();

        $input = $this->validate([
            'nombre_producto'       => 'min_length[3]|max_length[25]',
            'id_categoria'          => 'is_not_unique[categorias.id_categoria]',
            'precio_producto'       => 'numeric',
            'marca_producto'        => 'min_length[3]|max_length[25]',
            'descripcion_producto'  => 'min_length[3]|max_length[100]',
            'stock_producto'        => 'integer',
            'imagen_producto'       => 'permit_empty|is_image[imagen_producto]|mime_in[imagen_producto,image/jpg,image/webp,image/jpeg,image/png,image/gif]'
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
                'is_image'   => 'El archivo cargado no es una imagen válida.',
                'mime_in'    => 'El archivo cargado debe ser una imagen de tipo jpg, jpeg, gif, o png.'
            ]
        ]
       );
    
       if (!$input) {
        $data['categorias'] = $categoriasModel->getCategorias(); 
        $data['producto'] = $productoModel->find($id);

        $data['titulo'] = 'Editar Producto';


        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/Editar_producto', ['validation' => $this->validator])
        .view('proyecto/front/Pie_de_pagina');

       }else {
        $img = $this->request->getFile('imagen_producto');
        $oldImage = $productoModel->find($id)['imagen_producto'];
        $nombre_aleatorio = $oldImage; // Mantener el nombre de la imagen existente por defecto

            if ($img->isValid() && !$img->hasMoved()) {
                // Validar MIME en el servidor por seguridad
                $mime = $img->getMimeType();
                $allowedMimeTypes = ['image/jpg', 'image/webp', 'image/jpeg', 'image/png', 'image/gif'];

                if (in_array($mime, $allowedMimeTypes)) {
                    // Generar un nombre aleatorio para la nueva imagen y moverla
                    $nombre_aleatorio = $img->getRandomName();
                    $img->move(ROOTPATH . 'assets/uploads', $nombre_aleatorio);

                    // Eliminar la imagen antigua si existe
                    if ($oldImage && file_exists(ROOTPATH . 'assets/uploads/' . $oldImage)) {
                        unlink(ROOTPATH . 'assets/uploads/' . $oldImage);
                    }
                } else {
                    // Error si el MIME no es válido
                    return redirect()->back()->withInput()->with('error', 'El archivo cargado debe ser una imagen de tipo jpg, jpeg, png, o gif.');
                }
        }

        $data = [
            'nombre_producto'       => $this->request->getPost('nombre_producto'),
            'imagen_producto'       => $nombre_aleatorio,
            'id_categoria'          => $this->request->getPost('id_categoria'),
            'precio_producto'       => $this->request->getPost('precio_producto'), 
            'marca_producto'        => $this->request->getPost('marca_producto'),
            'descripcion_producto'  => $this->request->getPost('descripcion_producto'),
            'stock_producto'        => $this->request->getPost('stock_producto')
        ];

        $productoModel->update($id,$data);

        return redirect()->to(base_url('gestion_productos'))->with('modificado', 'Producto modificado con exito!');
        }
    }
}
    
