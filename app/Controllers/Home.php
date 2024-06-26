<?php

namespace App\Controllers;
use App\Models\Producto_Model;

class Home extends BaseController
{
    public function Principal(){
    $productoModel = new Producto_Model();
    
    // Fetch the latest 3 products
    $latestProducts = $productoModel->orderBy('id_producto', 'DESC')->findAll(3); // Fetching 3 latest products
    
    $data = [
        'titulo' => 'Ratita Sporting',
        'latestProducts' => $latestProducts, // Pass the latest products to the view
    ];

    return view('proyecto/front/Encabezado', $data)
           . view('proyecto/front/Barra_de_navegacion')
           . view('proyecto/front/Principal', $data) // Pass $data to your Principal view
           . view('proyecto/front/Pie_de_pagina');
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
