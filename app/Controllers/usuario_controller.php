<?php
namespace App\Controllers;
Use App\Models\Usuario_Model;

class Usuario_controller extends BaseController{

    public function __construct(){
           helper(['form', 'url', 'session']);

    }
    public function registro() {

        $data['titulo'] = 'registrarse';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/back/registro')
        .view('proyecto/front/Pie_de_pagina');

         //$dato['titulo']='Registro'; 
         //echo view('front/Encabezado',$dato);
         //echo view('front/Barra_de_navegacion');
         //echo view('Back/usuario/registro');
         //echo view('front/Pie_de_pagina');
      }
 
    public function nuevo_registro(){
        
        
        $validation = \Config\Services::validation();
             
        $input = $this->validate([
            'nombre'   => 'required|min_length[3]|max_length[25]',
            'apellido' => 'required|min_length[3]|max_length[25]',
            'usuario'  => 'required|min_length[3]|max_length[25]|is_unique[usuarios.usuario]',
            'email'    => 'required|min_length[4]|max_length[100]|valid_email|is_unique[usuarios.email]',
            'pass'     => 'required|min_length[3]|max_length[10]',
            're_pass'  => 'required|min_length[3]|max_length[10]|matches[pass]'
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
                'required'=>'Debe ingresar una contraseña que coincida con la de arriba',
                'max_lenght'=>'Supero el maximo de caracteres.',
                'min_length'=>'Debe ingresar al menos 3 caracteres.',
                'matches'=>'Las contraseñas no coinciden!'
            ]
        ]
        
       );
        $formModel = new Usuario_Model();
     
        if (!$input) {

            return view('proyecto/front/Encabezado')
                    .view('proyecto/front/Barra_de_navegacion')
                    .view('proyecto/back/registro', ['validation' => $this->validator])
                    .view('proyecto/front/Pie_de_pagina');
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
                'apellido'=> $this->request->getPost('apellido'),
                'usuario'=> $this->request->getPost('usuario'),
                'email'=> $this->request->getPost('email'),
                'perfil_id'=> '2',
                'baja'=>'NO',
                'pass' => password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT)
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
        helper('form');

        return view('proyecto/front/Encabezado')
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
        $session = session(); //el objeto de sesión se asigna a la variable $session
        $model = new Usuario_Model(); //instanciamos el modelo

        //traemos los datos del formulario
        $user = $this->request->getVar('usuario');
        $password = $this->request->getVar('pass');
        
        $data = $model->where('usuario', $user)->first(); //consulta sql 
        if($data){
            $pass = $data['pass'];
            $ba   = $data['baja'];
                if ($ba == 'SI'){
                    
                     $session->setFlashdata('msg', 'El usuario se encuentra inactivo. Contáctese con nosotros para recuperarlo.');
                     return redirect()->to(base_url('login'));
                 }
                    //Se verifican los datos ingresados para iniciar, si cumple la verificaciòn inicia la sesion
               $verify_pass = password_verify($password, $pass);
                   //password_verify determina los requisitos de configuracion de la contraseña
                   if($verify_pass){
                     $ses_data = [
                    'id_usuario' => $data['id_usuario'],
                    'nombre' => $data['nombre'],
                    'apellido'=> $data['apellido'],
                    'email' =>  $data['email'],
                    'usuario' => $data['usuario'],
                    'perfil_id'=> $data['perfil_id'],
                    'logged_in'  => TRUE
                ];
                  //Si se cumple la verificacion inicia la sesiòn  
                  $session->set($ses_data);

                  session()->setFlashdata('msg', 'Bienvenido!!');
                  return redirect()->to('panel');
                  // return redirect()->to('/prueba');//pagina principal
            }else{  
                 //no paso la validaciòn de la password
               $session->setFlashdata('msg', 'Contraseña incorrecta');
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
        return redirect()->to('/');
    }
}
