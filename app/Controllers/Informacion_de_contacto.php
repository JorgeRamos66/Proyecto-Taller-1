<?php

namespace App\Controllers;

class Informacion_de_contacto extends BaseController
{
    public function index()
    {
        return view('./proyecto/front/Encabezado.php').view('./proyecto/front/Barra_de_navegacion.php').view('./proyecto/front/Informacion_de_contacto.php').view('./proyecto/front/Pie_de_pagina.php');
    }
}
