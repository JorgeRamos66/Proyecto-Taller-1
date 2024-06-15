<?php
namespace App\Controllers;
Use App\Models\Usuarios_Model;

class Usuario_controller extends BaseController{

    public function __construct(){
           helper(['form', 'url']);

    }
    public function create() {
        
        return view('./proyecto/front/Encabezado.php')
        .view('./proyecto/front/Barra_de_navegacion.php')
        .view('./proyecto/back/registro.php')
        .view('./proyecto/front/Pie_de_pagina.php');

         //$dato['titulo']='Registro'; 
         //echo view('front/Encabezado',$dato);
         //echo view('front/Barra_de_navegacion');
         //echo view('Back/usuario/registro');
         //echo view('front/Pie_de_pagina');
      }
 
    public function formValidation() {
             
        $input = $this->validate([
            'nombre'   => 'required|min_length[3]|max_length[25]',
            'apellido' => 'required|min_length[3]|max_length[25]',
            'usuario'  => 'required|min_length[3]|max_length[25]',
            'email'    => 'required|min_length[4]|max_length[100]|valid_email|is_unique[usuarios.email]',
            'pass'     => 'required|min_length[3]|max_length[10]'
        ],
        
       );
        $formModel = new Usuarios_Model();
     
        if (!$input) {

            return view('./proyecto/front/Encabezado.php')
                    .view('./proyecto/front/Barra_de_navegacion.php')
                    .view('./proyecto/back/registro.php', ['validation' => $this->validator])
                    .view('./proyecto/front/Pie_de_pagina.php');
                    /*
               $data['titulo']='Registro'; 
                echo view('front/Encabezado',$data);
                echo view('front/Barra_de_navegacion');
                echo view('Back/usuario/registro', ['validation' => $this->validator]);
                echo view('front/Pie_de_pagina');
*/
        } else {
            
            $formModel->save([
                'nombre' => $this->request->getPost('nombre'),
                'apellido'=> $this->request->getVar('apellido'),
                'usuario'=> $this->request->getVar('usuario'),
                'email'=> $this->request->getVar('email'),
                'pass' => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT)
              //password_hash() crea un nuevo hash de contraseña usando un algoritmo de hash de único sentido.
            ]);  
             
            // Flashdata funciona solo en redirigir la función en el controlador en la vista de carga.
               session()->setFlashdata('success', 'Usuario registrado con exito');
                //return redirect()->to('/registro');
            return $this->response->redirect(site_url('login'));
        }
    }
    public function registrar(){
        
    }
}
