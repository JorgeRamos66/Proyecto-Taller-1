<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function Principal()
    {
        return view('./proyecto/front/Encabezado.php')
        .view('./proyecto/front/Barra_de_navegacion.php')
        .view('./proyecto/front/Principal.php')
        .view('./proyecto/front/Pie_de_pagina.php');
    }
    public function Quienes_somos()
    {
        return view('./proyecto/front/Encabezado.php')
        .view('./proyecto/front/Barra_de_navegacion.php')
        .view('./proyecto/front/Quienes_somos.php')
        .view('./proyecto/front/Pie_de_pagina.php');
    }
    public function Comercializacion()
    {
        return view('./proyecto/front/Encabezado.php')
        .view('./proyecto/front/Barra_de_navegacion.php')
        .view('./proyecto/front/Comercializacion.php')
        .view('./proyecto/front/Pie_de_pagina.php');
    }
    public function Informacion_de_contacto()
    {
        return view('./proyecto/front/Encabezado.php')
        .view('./proyecto/front/Barra_de_navegacion.php')
        .view('./proyecto/front/Informacion_de_contacto.php')
        .view('./proyecto/front/Pie_de_pagina.php');
    }
    public function Terminos_y_usos()
    {
        return view('./proyecto/front/Encabezado.php')
        .view('./proyecto/front/Barra_de_navegacion.php')
        .view('./proyecto/front/Terminos_y_usos.php')
        .view('./proyecto/front/Pie_de_pagina.php');
    }
}
