<?php
namespace App\Controllers;
Use App\Models\Usuario_Model;

class Usuario_controller extends BaseController{

    public function __construct(){
        helper(['form', 'url', 'session']);

    }
    public function registro() {
        helper(['form', 'url', 'session']);

        $data['titulo'] = 'Registro';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/back/registro')
        .view('proyecto/front/Pie_de_pagina');
      }
 
    public function nuevo_registro(){
        helper(['form', 'url', 'session']);
        
        $validation = \Config\Services::validation();
             
        $input = $this->validate([
            'nombre'   => 'required|min_length[3]|max_length[25]',
            'apellido' => 'required|min_length[3]|max_length[25]',
            'usuario'  => 'required|min_length[3]|max_length[25]|is_unique[usuarios.usuario]',
            'email'    => 'required|min_length[4]|max_length[100]|valid_email|is_unique[usuarios.email]',
            'pass'     => 'required|min_length[3]|max_length[10]',
            're_pass'  => 'matches[pass]'
        ],
        [
            'nombre'=>[
                'required'=>'Debe ingresar un nombre que tenga entre 3 y 25 caracteres.',
                'max_lenght'=>'Supero el maximo de caracteres.',
                'min_length'=>'Debe tener minimo 3 caracteres.'
            ],
            'apellido'=>[
                'required'=>'Debe ingresar un apellido que tenga entre 3 y 25 caracteres.',
                'max_lenght'=>'Supero el maximo de caracteres.',
                'min_length'=>'Debe tener minimo 3 caracteres.'
            ],
            'usuario'=>[
                'required'=>'Debe ingresar un usuario que tenga entre 3 y 25 caracteres.',
                'max_lenght'=>'Supero el maximo de caracteres.',
                'min_length'=>'Debe tener minimo 3 caracteres.',
                'is_unique'=>'Este usuario ya se encuentra registrado, pruebe con otro.'
            ],
            'email'=>[
                'required'=>'Debe ingresar un correo electronico.',
                'max_lenght'=>'Supero el maximo de caracteres.',
                'min_length'=>'Debe tener minimo 4 caracteres',
                'valid_email'=>'Debe ingresar una cuenta de correo valido.',
                'is_unique'=>'El correo ya se encuentra registrado, intente con otro.'
            ],
            'pass'=>[
                'required'=>'Debe ingresar una contraseña que tenga entre 3 y 10 caracteres.',
                'max_lenght'=>'Supero el maximo de caracteres.',
                'min_length'=>'Debe ingresar al menos 3 caracteres.'
            ],
            're_pass'=>[
                'matches'=>'Las contraseñas no coinciden!'
            ]
        ]
       );
        $formModel = new Usuario_Model();
        if (!$input) {
            $data['titulo'] = 'Registro';
            return view('proyecto/front/Encabezado', $data)
                    .view('proyecto/front/Barra_de_navegacion')
                    .view('proyecto/back/registro', ['validation' => $this->validator])
                    .view('proyecto/front/Pie_de_pagina');
        } else {
            $formModel->save([
                'nombre'    => $this->request->getPost('nombre'),
                'apellido'  => $this->request->getPost('apellido'),
                'usuario'   => $this->request->getPost('usuario'),
                'email'     => $this->request->getPost('email'),
                'perfil_id' => '2',
                'baja'      =>'NO',
                'pass'      => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT)
              //password_hash() crea un nuevo hash de contraseña usando un algoritmo de hash de único sentido.
            ]);
            // Flashdata funciona solo en redirigir la función en el controlador en la vista de carga.
               session()->setFlashdata('success', 'Usuario registrado con exito');
               return redirect()->to(base_url('login'))->with('mensaje', 'El registro ha sido exitoso!');
            //return redirect()->to('login')->with('mensaje','El registro ha sido exitoso!');
            //return $this->response->redirect(site_url('login'));
            //return redirect()->route('login')->with('mensaje','El registro ha sido exitoso!');
            
        }
    }
    public function login()
    {
        helper(['form', 'url', 'session']);

        $data['titulo'] = 'Login';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/back/login')
        .view('proyecto/front/Pie_de_pagina');
      
        //$dato['titulo']='login'; 
        //echo view('front/Encabezado');
        //echo view('front/Barra_de_navegacion');
        //echo view('Back/usuario/login');
        //echo view('front/Pie_de_pagina');
    }

  
    public function auth()
    {
        helper(['form', 'url', 'session']);

        $session = session(); //el objeto de sesión se asigna a la variable $session
        $usuarioModel = new Usuario_Model(); //instanciamos el modelo

        //traemos los datos del formulario
        $usuario = $this->request->getPost('usuario');
        $password = $this->request->getVar('pass');
        
                    
        
        $usuarioActual = $usuarioModel->where('usuario', $usuario)->first(); //consulta sql 
        //$usuarioActual = $this->request->getPost(['user', ''])

        
        if($usuarioActual){

                if ($usuarioActual['baja'] == 'SI'){
                    
                     $session->setFlashdata('msg', 'El usuario se encuentra inactivo. Contáctese con nosotros para recuperarlo.');
                     return redirect()->to(base_url('login'));
                 }
                    //Se verifican los datos ingresados para iniciar, si cumple la verificaciòn inicia la sesion
                    //$verify_pass = password_verify($password, $pass);
                    //password_verify determina los requisitos de configuracion de la contraseña
                   if(password_verify($password, $usuarioActual['pass'])){
                     $ses_data = [
                    'id_usuario' => $usuarioActual['id_usuario'],
                    'nombre'     => $usuarioActual['nombre'],
                    'apellido'   => $usuarioActual['apellido'],
                    'email'      => $usuarioActual['email'],
                    'usuario'    => $usuarioActual['usuario'],
                    'perfil_id'  => $usuarioActual['perfil_id'],
                    'es_admin'   => ($usuarioActual['perfil_id']==1),
                    'baja'       => $usuarioActual['baja'],
                    'loggedIn'   => true
                ];
                  //Si se cumple la verificacion inicia la sesiòn  
                  $session->set($ses_data);

                  session()->setFlashdata('msg', 'Bienvenido!!');

                  return redirect()->to(base_url('/'));
                  
                  // return redirect()->to('/prueba');//pagina principal
            }else{
                 //no paso la validaciòn de la password
               $session->setFlashdata('msg', 'Contraseña incorrecta');
               $session->setFlashdata('msg', password_hash($password, PASSWORD_DEFAULT));
               return redirect()->to(base_url('login'));
         }   
        }else{
             //no paso la validaciòn del usuario
            $session->setFlashdata('msg', 'El usuario no existe o no esta bien escroto');
            return redirect()->to(base_url('login'));
        }
  }
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('/'));
    }

    public function listar_usuarios(){

        $usuarioModel = new Usuario_Model();
        
        $data['usuarios'] = $usuarioModel->getUsuariosTodos();
        $data['titulo'] = 'Gestion productos';

        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/Gestion_usuarios')
        .view('proyecto/front/Pie_de_pagina');
    }


}
