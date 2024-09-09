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
               return redirect()->to(base_url('login'))->with('exito', 'El registro ha sido exitoso!');
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
      

    }

  
    public function auth() {
    helper(['form', 'url', 'session']);

    $session = session();
    $usuarioModel = new Usuario_Model();

    // Define validation rules
    $rules = [
        'usuario' => [
            'label' => 'Usuario',
            'rules' => 'required',
            'errors' => [
                'required' => 'Debe ingresar un nombre de usuario.',
            ]
        ],
        'pass' => [
            'label' => 'Contraseña',
            'rules' => 'required',
            'errors' => [
                'required' => 'Debe ingresar una contraseña.'
            ]
        ]
    ];

    // Validate form input
    if (!$this->validate($rules)) {
        return view('proyecto/front/Encabezado')
                .view('proyecto/front/Barra_de_navegacion')
                .view('proyecto/back/login', ['validation' => $this->validator])
                .view('proyecto/front/Pie_de_pagina');
    }

    // Fetch form data
    $usuario = $this->request->getPost('usuario');
    
    // Fetch user from database
    $usuarioActual = $usuarioModel->where('usuario', $usuario)->first();

    // If user does not exist
    if (!$usuarioActual) {
        $session->setFlashdata('msg', 'El usuario no existe o no está bien escrito');
        return redirect()->to(base_url('login'));
    }
    // Check if the user is inactive
    if ($usuarioActual['baja'] == 'SI') {
        $session->setFlashdata('msg', 'El usuario se encuentra inactivo. Contáctese con nosotros para recuperarlo.');
        return redirect()->to(base_url('login'));
    }
    $password = $this->request->getVar('pass');

    
    // Verify password
    if (password_verify($password, $usuarioActual['pass'])) {
        // Set session data
        $ses_data = [
            'id_usuario' => $usuarioActual['id_usuario'],
            'nombre'     => $usuarioActual['nombre'],
            'apellido'   => $usuarioActual['apellido'],
            'email'      => $usuarioActual['email'],
            'usuario'    => $usuarioActual['usuario'],
            'perfil_id'  => $usuarioActual['perfil_id'],
            'es_admin'   => ($usuarioActual['perfil_id'] == 1),
            'baja'       => $usuarioActual['baja'],
            'loggedIn'   => true
        ];
        
        $session->set($ses_data);
        session()->setFlashdata('msg', 'Bienvenido!!');
        return redirect()->to(base_url('/'));
    } else {
        // Incorrect password
        $session->setFlashdata('msg', 'Contraseña incorrecta');
        return redirect()->to(base_url('login'));
    }
}
    
    public function logout()
    {
        $session = session();
        $session->destroy();
        return redirect()->to(base_url('login'));
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
    public function eliminar_usuario($id=null){
        $usuarioModel = new Usuario_Model();
        $data['baja'] = 'SI';
        $usuarioModel->update($id,$data);

        return redirect()->to(base_url('gestion_usuarios'))->with('eliminado', 'Usuario dado de baja!');

    }
    public function activar_usuario($id=null){
        $usuarioModel = new Usuario_Model();
        $data['baja'] = 'NO';
        $usuarioModel->update($id,$data);

        return redirect()->to(base_url('gestion_usuarios'))->with('activado', 'Usuario dado de alta!');

    }

    public function perfil_usuario($encodedId = null)
    {
        // Decodificar el ID del usuario
        $id = base64_decode($encodedId);

        // Verificar si el ID es válido
        if (!is_numeric($id)) {
            return redirect()->back()->with('msg', 'ID no válido.');
        }

        $usuarioModel = new Usuario_Model();
        $data['usuario'] = $usuarioModel->find($id);
        $data['titulo'] = 'Perfil';

        return view('proyecto/front/Encabezado', $data)
            . view('proyecto/front/Barra_de_navegacion')
            . view('proyecto/back/Perfil_usuario')
            . view('proyecto/front/Pie_de_pagina');
    }

    public function editar_usuario($encodedId = null)
    {
        // Decodificar el ID del usuario
        $id = base64_decode($encodedId);

        // Verificar si el ID es válido
        if (!is_numeric($id)) {
            return redirect()->back()->with('msg', 'ID no válido.');
        }

        $usuarioModel = new Usuario_Model();
        $data['usuario'] = $usuarioModel->find($id);
        $data['titulo'] = 'Editar Perfil';

        return view('proyecto/front/Encabezado', $data)
            . view('proyecto/front/Barra_de_navegacion')
            . view('proyecto/back/Editar_perfil')
            . view('proyecto/front/Pie_de_pagina');
    }
    public function actualizar_perfil($encodedId = null) {
        helper(['form', 'url', 'session']);
        $id = base64_decode($encodedId);

        // Verificar si el ID es válido
        if (!is_numeric($id)) {
            return redirect()->back()->with('msj', 'ID no válido.');
        }
        $usuarioModel = new Usuario_Model();
    
        // Common validation rules
        $input = $this->validate([
            'nombre'   => 'required|min_length[3]|max_length[25]',
            'apellido' => 'required|min_length[3]|max_length[25]',
            'usuario'  => 'required|min_length[3]|max_length[25]',
            'email'    => 'required|min_length[4]|max_length[100]|valid_email'
        ], [
            'nombre' => [
                'required' => 'Debe ingresar un nombre que tenga entre 3 y 25 caracteres.',
                'max_length' => 'Superó el máximo de caracteres.',
                'min_length' => 'Debe tener mínimo 3 caracteres.'
            ],
            'apellido' => [
                'required' => 'Debe ingresar un apellido que tenga entre 3 y 25 caracteres.',
                'max_length' => 'Superó el máximo de caracteres.',
                'min_length' => 'Debe tener mínimo 3 caracteres.'
            ],
            'usuario' => [
                'required' => 'Debe ingresar un usuario que tenga entre 3 y 25 caracteres.',
                'max_length' => 'Superó el máximo de caracteres.',
                'min_length' => 'Debe tener mínimo 3 caracteres.'
            ],
            'email' => [
                'required' => 'Debe ingresar un correo electrónico.',
                'max_length' => 'Superó el máximo de caracteres.',
                'min_length' => 'Debe tener mínimo 4 caracteres.',
                'valid_email' => 'Debe ingresar una cuenta de correo válida.'
            ]
        ]);
    
        if (!$input) {
            $data['usuario'] = $usuarioModel->find($id);
            $data['titulo'] = 'Editar Perfil';
            return view('proyecto/front/Encabezado', $data)
                . view('proyecto/front/Barra_de_navegacion')
                . view('proyecto/back/Editar_perfil', ['validation' => $this->validator])
                . view('proyecto/front/Pie_de_pagina');
        }
    
        if ($this->request->getPost('pass-checkbox')) {
            $usuario = $usuarioModel->find($id);
            $old_pass_db = $usuario['pass'];
            $old_pass = $this->request->getVar('pass_old');
            if (password_verify($old_pass, $old_pass_db)) {
                $input = $this->validate([
                    'pass' => 'required|min_length[3]|max_length[10]',
                    're_pass' => 'matches[pass]'
                ], [
                    'pass' => [
                        'required' => 'Debe ingresar una contraseña que tenga entre 3 y 10 caracteres.',
                        'max_length' => 'Superó el máximo de caracteres.',
                        'min_length' => 'Debe ingresar al menos 3 caracteres.'
                    ],
                    're_pass' => [
                        'matches' => 'Las contraseñas no coinciden!'
                    ]
                ]);
    
                if (!$input) {
                    $data['usuario'] = $usuarioModel->find($id);
                    $data['titulo'] = 'Editar Perfil';
                    return view('proyecto/front/Encabezado', $data)
                        . view('proyecto/front/Barra_de_navegacion')
                        . view('proyecto/back/Editar_perfil', ['validation' => $this->validator])
                        . view('proyecto/front/Pie_de_pagina');
                }
            } else {
                $data['usuario'] = $usuarioModel->find($id);
                session()->setFlashdata('msj', 'La contraseña actual no coincide con la antigua.');
                
                $data['titulo'] = 'Editar Perfil';
                return view('proyecto/front/Encabezado', $data)
                    . view('proyecto/front/Barra_de_navegacion')
                    . view('proyecto/back/Editar_perfil', ['validation' => $this->validator])
                    . view('proyecto/front/Pie_de_pagina');
            }
        }
    
        // Passed validations
        $data = [
            'nombre' => $this->request->getPost('nombre'),
            'apellido' => $this->request->getPost('apellido'),
            'usuario' => $this->request->getPost('usuario'),
            'email' => $this->request->getPost('email')
        ];
    
        if ($this->request->getPost('pass-checkbox')) {
            $data['pass'] = password_hash($this->request->getVar('pass'), PASSWORD_DEFAULT);
        }
    
        // Update the user in the database
        $usuarioModel->update($id, $data);
    
        return redirect()->to(base_url('perfil-usuario/' . base64_encode($id)))->with('msj', 'Perfil actualizado correctamente. Vuelva a iniciar sesion para visualizar los cambios');
    }
    


}
