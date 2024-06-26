<?php

namespace App\Controllers;
Use App\Models\Producto_Model;
use App\Models\Cabecera_Ventas_Model;
use App\Models\Detalle_Ventas_Model;

class Carrito_controller extends BaseController{

    public function __construct(){
        helper(['form','url','cart']);

        $session = session();
        $cart = \config\Services::cart();
        $cart->contents();    
    }

    public function ver_carrito() {

        helper(['form','url','cart']);
        $cart = \Config\Services::cart();
        $data['carrito'] = $cart->contents();
    
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/back/Carrito')
        .view('proyecto/front/Pie_de_pagina');
    }

    public function agregar_al_carrito() {
        $cart = \Config\Services::cart();
        $request = \Config\Services::request();
    
        $data = [
            'id'      => $request->getPost('id_producto'),
            'qty'     => $request->getPost('cantidad'),
            'price'   => $request->getPost('precio'),
            'name'    => $request->getPost('nombre_producto'),
        ];
    
        // Validar los datos antes de insertarlos en el carrito
        if ($this->validateCartData($data)) {
            $cart->insert($data);
        }
    
        return redirect()->to(base_url('catalogoDeProductos'))->with('msj', 'Producto agregado al carrito');
    }

    public function remover_del_carrito($rowid) {
        $cart = \Config\Services::cart();
        $request = \Config\Services::request();

        if ($rowid == 'all'){
            $cart->destroy();
        }
        else{
            $cart->remove($rowid);
        }
        return redirect()->back()->withInput();

    }

    public function actualiza_carrito($rowid) {
        $session = session();
        $cart = \Config\Services::cart();
        $request = \Config\Services::request();

        $productoId = $cart[$rowid]['producto_id'];

        $stockDisponible = $this->obtenerStock($productoId);
        $qty = $this->request->getPost('qty');

        if ($qty < $stockDisponible){
            $session->set('cart', $cart);
            $data = [
                'qty'   => $request->getPost('qty'),  // Accept quantity from user input
            ];
    
            // Validate input data
            if ($this->validateCartData($data)) {
                $cart->update($data);
            }
            return redirect()->back();
        }else{
            return redirect()->back()->with('mensaje', 'No hay stock disponible para seguir incrementando la compra');
        }
    }
    public function obtenerStock($id_producto){

        $productoModel = new Producto_Model();
        // Consulta a la base de datos para obtener el stock del producto
        $producto = $productoModel->find($id_producto);
        
        if ($producto) {
            return $producto['stock'];
        } else {
            //Si el producto no existe retorna 0 (Esto es opcional, sujeto a pruebas posteriores)
            //Si el producto esta añadido a carrito debería existir
            return 0;
        }
    }


    public function devolver_carrito() {
        $cart = \Config\Services::cart();  
        return $cart->contents(); // Return cart contents
    }

    private function validateCartData($data) {
        // Validar que todos los campos requeridos están presentes
        return isset($data['id'], $data['qty'], $data['price'], $data['name']) &&
               is_numeric($data['price']) && is_numeric($data['qty']);
    }
    
}