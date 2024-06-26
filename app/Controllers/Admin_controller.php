<?php

namespace App\Controllers;
use App\Models\Producto_Model;

class Admin_controller extends BaseController{
    
    
    public function Admin_view(){
        
        $productoModel = new Producto_Model();
        
        // Fetch the latest 3 products
        $latestProducts = $productoModel->orderBy('id_producto', 'DESC')->findAll(3); // Fetching 3 latest products
        
        $data = [
            'titulo' => 'Ratita Sporting',
            'latestProducts' => $latestProducts, // Pass the latest products to the view
        ];
    
        return view('proyecto/front/Encabezado', $data)
               . view('proyecto/front/Barra_de_navegacion_admin')
               . view('proyecto/front/Principal', $data) // Pass $data to your Principal view
               . view('proyecto/front/Pie_de_pagina');
    }

}