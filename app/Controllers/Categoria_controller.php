<?php
namespace App\Controllers;
use App\Models\Categoria_Model;
use CodeIgniter\Controller;

class Categoria_controller extends BaseController
{
    protected $categoriaModel;
    public function __construct()
    {
        helper(['url', 'form']);
        $this->categoriaModel = new Categoria_Model();
    }

    public function gestion_categorias()
    {
        $search = $this->request->getGet('search');
        $itemsPerPage = $this->request->getGet('itemsPerPage') ?? 5;
        
        if ($search) {
            $categorias = $this->categoriaModel->groupStart()
                                              ->like('descripcion_categoria', $search)
                                              ->groupEnd()
                                              ->paginate($itemsPerPage, 'categorias');
        } else {
            $categorias = $this->categoriaModel->paginate($itemsPerPage, 'categorias');
        }

        $pager = $this->categoriaModel->pager;
        $pager->setPath('gestion_categorias'); // Establecer la ruta base para la paginación

        $data = [
            'categorias' => $categorias,
            'pager' => $pager,
            'itemsPerPage' => $itemsPerPage,
            'search' => $search,
            'titulo' => 'Gestión de Categorías',
        ];

        return view('proyecto/front/Encabezado', $data)
            .view('proyecto/front/Barra_de_navegacion_admin')
            .view('proyecto/back/Gestion_categorias', $data)
            .view('proyecto/front/Pie_de_pagina');
    }

    public function crear_categoria()
    {
        $data['titulo'] = 'Alta Categoría';
        return view('proyecto/front/Encabezado', $data)
            .view('proyecto/front/Barra_de_navegacion_admin')
            .view('proyecto/back/Alta_categoria')
            .view('proyecto/front/Pie_de_pagina');
    }

    public function store()
    {
        $input = $this->validate([
            'descripcion_categoria' => 'required|min_length[3]|max_length[50]',
        ],
        [
            'descripcion_categoria' => [
                'required' => 'Debe ingresar una descripción.',
                'min_length' => 'La descripción debe tener al menos 3 caracteres.',
                'max_length' => 'La descripción no puede tener más de 50 caracteres.',
            ],
        ]);

        if (!$input) {
            $data['titulo'] = 'Alta Categoría';
            return view('proyecto/front/Encabezado', $data)
                .view('proyecto/front/Barra_de_navegacion_admin')
                .view('proyecto/back/Alta_categoria', ['validation' => $this->validator])
                .view('proyecto/front/Pie_de_pagina');
        } else {
            $data = [
                'descripcion_categoria' => $this->request->getPost('descripcion_categoria'),
                'activo_categoria' => 'SI',
            ];

            $this->categoriaModel->insert($data);
            return redirect()->to(base_url('gestion_categorias'))->with('agregado', 'Categoría agregada!');
        }
    }

    public function editar_categoria($id = null)
    {
        // Busca la categoría por ID
        $categoria = $this->categoriaModel->find($id);

        // Verifica si la categoría existe
        if (!$categoria) {
            return redirect()->to('gestion_categorias')->with('error', 'Categoría no encontrada');
        }

        // Pasa los datos de la categoría a la vista
        $data = [
            'categoria' => $categoria,
            'titulo' => 'Editar Categoría'
        ];

        // Carga las vistas con los datos de la categoría
        return view('proyecto/front/Encabezado', $data)
            . view('proyecto/front/Barra_de_navegacion_admin')
            . view('proyecto/back/Editar_categoria', $data) // Cambiamos la vista para usar el formulario de alta
            . view('proyecto/front/Pie_de_pagina');
    }

    public function update($id = null)
    {
        $input = $this->validate([
            'descripcion_categoria' => 'required|min_length[3]|max_length[50]',
        ],
        [
            'descripcion_categoria' => [
                'required' => 'Debe ingresar una descripción.',
                'min_length' => 'La descripción debe tener al menos 3 caracteres.',
                'max_length' => 'La descripción no puede tener más de 50 caracteres.',
            ],
        ]);

        if (!$input) {
            $data['categoria'] = $this->categoriaModel->find($id);
            $data['titulo'] = 'Editar Categoría';

            return view('proyecto/front/Encabezado', $data)
                .view('proyecto/front/Barra_de_navegacion_admin')
                .view('proyecto/back/Editar_categoria', ['validation' => $this->validator])
                .view('proyecto/front/Pie_de_pagina');
        } else {
            // Captura el estado del checkbox; si no está marcado, será "NO"
            $estadoActivo = $this->request->getPost('activo_categoria') === 'SI' ? 1 : 0;

            $data = [
                'descripcion_categoria' => $this->request->getPost('descripcion_categoria'),
                'activo_categoria' => $estadoActivo,
            ];

            $this->categoriaModel->update($id, $data);
            return redirect()->to(base_url('gestion_categorias'))->with('modificado', 'Categoría modificada con éxito!');
        }
    }

    public function activar_categoria($id = null)
    {
        $data = ['activo_categoria' => 1];
        $this->categoriaModel->update($id, $data);

        return redirect()->to(base_url('gestion_categorias'))->with('activado', 'Categoría activada!');
    }

    public function eliminar_categoria($id = null)
    {
        $data = ['activo_categoria' => 0];
        $this->categoriaModel->update($id, $data);

        return redirect()->to(base_url('gestion_categorias'))->with('eliminado', 'Categoría eliminada!');
    }
}