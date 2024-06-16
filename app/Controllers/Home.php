<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function Principal()
    {
        return view('proyecto/front/Encabezado')
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/front/Principal')
        .view('proyecto/front/Pie_de_pagina');
    }
    public function Quienes_somos()
    {
        return view('proyecto/front/Encabezado')
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/front/Quienes_somos')
        .view('proyecto/front/Pie_de_pagina');
    }
    public function Comercializacion()
    {
        return view('proyecto/front/Encabezado')
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/front/Comercializacion')
        .view('proyecto/front/Pie_de_pagina');
    }
    public function Informacion_de_contacto()
    {
        return view('proyecto/front/Encabezado')
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/front/Informacion_de_contacto')
        .view('proyecto/front/Pie_de_pagina');
    }
    public function Terminos_y_usos()
    {
        return view('proyecto/front/Encabezado')
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/front/Terminos_y_usos')
        .view('proyecto/front/Pie_de_pagina');
    }
}
