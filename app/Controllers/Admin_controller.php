<?php

namespace App\Controllers;

class Admin_controller extends BaseController
{
    public function Admin_view()
    {
        $data['titulo'] = 'Ratita Sporting';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/front/Principal')
        .view('proyecto/front/Pie_de_pagina');
    }

    public function listar_productos()
    {
        $data['titulo'] = 'Gestion productos';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion_admin')
        .view('proyecto/back/Gestion_productos')
        .view('proyecto/front/Pie_de_pagina');
    }
}