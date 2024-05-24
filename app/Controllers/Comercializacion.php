<?php

namespace App\Controllers;

class Comercializacion extends BaseController
{
    public function index()
    {
        return view('./proyecto/front/Encabezado.php').view('./proyecto/front/Barra_de_navegacion.php').view('./proyecto/front/Comercializacion.php').view('./proyecto/front/Pie_de_pagina.php');
    }
}
