<?php
namespace App\Controllers;
Use App\Models\Consulta_Model;
Use App\Models\Consulta_Registrado_Model;

class Contacto_controller extends BaseController{

    public function __construct(){
        helper(['form', 'url', 'session']);

    }
    public function contacto()
    {
        $data['titulo'] = 'Informacion de contacto';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/front/Informacion_de_contacto')
        .view('proyecto/front/Pie_de_pagina');
    }
    public function nueva_consulta($tipo=null){
        helper(['form', 'url', 'session']);
        
        $validation = \Config\Services::validation();
        $request = \Config\Services::request();



        $input = $this->validate([
                'nombre'=>'required|min_length[3]|max_length[25]',
                'apellido'=>'required|min_length[3]|max_length[25]',
                'email'=>'required|max_length[100]',
                'mensaje'=>'required|max_length[500]'                
            ],
            [                
                'nombre'=>[
                    'required'=>'Debe ingresar su nombre para hacer la consulta.',
                    'max_length'=>'Supero el maximo de caracteres.'
                ],
                'apellido'=>[
                    'required'=>'Debe ingresar su apellido para hacer la consulta.',
                    'max_length'=>'Supero el maximo de caracteres.'
                ],
                'email'=>[
                    'required'=>'Debe ingresar un correo electronico de contacto.',
                    'max_length'=>'Supero el maximo de caracteres.'
                ],
                'mensaje'=>[
                    'required'=>'Debe ingresar una consulta para que podamos contactarnos con usted.',
                    'max_length'=>'Supero el maximo de caracteres.'
                ]               
            ]
        );
        //Control de validaciones

        $consultaModel = new Consulta_Model();

        if(!$input){
            //Obtener los datos del formulario si pasa la validacion correspondiente
            $data['titulo'] = 'Informacion de contacto';
            return view('proyecto/front/Encabezado', $data)
                .view('proyecto/front/Barra_de_navegacion')
                .view('proyecto/front/Informacion_de_contacto', ['validation' => $this->validator])
                .view('proyecto/front/Pie_de_pagina');
            
           
        }else{
            if ($tipo == '1'){
                $data = 
            
                $consultaModel->save([
                    'consulta_nombre'     =>$request->getPost('nombre'),
                    'consulta_apellido'   =>$request->getPost('apellido'),
                    'consulta_email'      =>$request->getPost('email'),
                    'consulta_mensaje'    =>$request->getPost('mensaje'),
                    'consulta_leido'      => 'NO'
                ]);
            }else {
                $data = 
            
                $consultaModel->save([
                    'consulta_nombre'     =>$request->getPost('nombre'),
                    'consulta_apellido'   =>$request->getPost('apellido'),
                    'consulta_email'      =>$request->getPost('email'),
                    'consulta_mensaje'    =>$request->getPost('mensaje'),
                    'consulta_registrado' => 'SI',
                    'consulta_leido'      => 'NO'
                ]);
            }

            session()->setFlashdata('msj', 'La consulta se ha realizado con exito. ¡Pronto nos comunicaremos con usted!');
            return redirect()->to(base_url('informacion_de_contacto'));

        }
    }
    public function listar_consultas() {
        $consultaModel = new Consulta_Model();
        
        // Obtener el término de búsqueda y número de elementos por página
        $search = $this->request->getGet('search');
        $itemsPerPage = $this->request->getGet('itemsPerPage') ?? 9;
        
        // Aplicar filtro de búsqueda si existe
        if ($search) {
            $consultas = $consultaModel->groupStart()
                                       ->like('consulta_nombre', $search)
                                       ->orLike('consulta_apellido', $search)
                                       ->orLike('consulta_email', $search)
                                       ->orLike('consulta_mensaje', $search)
                                       ->groupEnd()
                                       ->paginate($itemsPerPage, 'consultas');
        } else {
            $consultas = $consultaModel->paginate($itemsPerPage, 'consultas');
        }
        
        $pager = $consultaModel->pager;
        $pager->setPath('listar_consultas'); // Establece la ruta base para la paginación
        
        $data = [
            'consultas' => $consultas,
            'pager' => $pager,
            'search' => $search
        ];
        
        return view('proyecto/front/Encabezado', $data)
            . view('proyecto/front/Barra_de_navegacion_admin')
            . view('proyecto/back/Gestion_consultas', $data) // Pasa $data aquí
            . view('proyecto/front/Pie_de_pagina');
    }

    public function marcar_consulta_leido($id = null) {
        if ($id === null) {
            // Handle case where $id is not provided or invalid
            return;
        }
    
        $consultaModel = new Consulta_Model();
        $consulta = $consultaModel->find($id);

        $data = ['consulta_leido' => $consulta['consulta_leido'] === 'SI' ? 'NO' : 'SI'];
        
        // Update the consultation's 'consulta_leido' field to 'SI'
        $consultaModel->update($id, $data);
    
        // Redirect back to the gestion_consultas page or any other desired page
        return redirect()->to(base_url('gestion_consultas'));
    }


    public function marcar_consulta_desleido($id=null){
        $consultaModel = new Consulta_Model();
        
        $consultaModel ->update($id, ['consulta_leido' => 'NO']);

        session()->setFlashdata('msj', 'El mensaje se ha marcado como LEIDO.');
        return redirect()->back();
    }

    public function buscar_mensaje_contacto(){
        $consultaModel = new Consulta_Model();

        $query = $this->request->getGet('query');

        $consultas = $consultaModel->like('consulta_email', $query)
                ->orLike('consulta_nombre', $query)
                ->findAll();

        //return view('contenido/back/gestion_productos', ['productos' => $productos]);
        $data['titulo'] = 'Mensaje contactos';
        $data['consultas'] = $consultas;
        $data['query'] = $query;

        return view('proyecto/front/Encabezado')
        .view('proyecto/front/Barra_de_navegacion_admin', $data)
        .view('proyecto/front/mensajes_contactos')
        .view('proyecto/front/Pie_de_pagina');
    }
}