<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function Principal()
    {
        $data['titulo'] = 'Ratita Sporting';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/front/Principal')
        .view('proyecto/front/Pie_de_pagina');
    }
    public function Quienes_somos()
    {
        $data['titulo'] = 'Quienes somos';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/front/Quienes_somos')
        .view('proyecto/front/Pie_de_pagina');
    }
    public function Comercializacion()
    {
        $data['titulo'] = 'Comercializacion';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/front/Comercializacion')
        .view('proyecto/front/Pie_de_pagina');
    }
    public function Terminos_y_usos()
    {
        $data['titulo'] = 'Terminos y usos';
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/front/Terminos_y_usos')
        .view('proyecto/front/Pie_de_pagina');
    }
}
