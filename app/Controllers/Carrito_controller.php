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

    //Ver el carrito
    public function ver_carrito(){

        helper(['form','url','cart']);
        $cart = \config\Services::cart();
        $cart = $this->session->get('cart') ?? [];
        $productoModel = new Producto_Model();

        

        //Obtener datos adicionales del producto
        foreach ($cart as &$item) {
            $producto = $productoModel->find($item['id']);
            //Se agregan los datos del producto en el item del cart para utilizarlo en caso de que sea necesario (por ejemplo: STOCK)
            if ($producto){
                $item['producto'] = $producto;
            } else {
                //En el caso en que el producto no se encuentra
                $item['producto'] = null;
            }
        }
        
        //Se agregan los datos para mostrar en la vista:
        $data = [
            'titulo' => 'Carrito de Compras',
            'cart' => $cart,
        ];

        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/back/Carrito')
        .view('proyecto/front/Pie_de_pagina');
    }

    public function agregar_al_carrito() {
        // Initialize the cart service
        $cart = \Config\Services::cart();
        
        // Retrieve the current session cart or create an empty array if it doesn't exist
        $sessionCart = $this->session->get('cart') ?? [];
    
        // Load the product model
        $productoModel = new Producto_Model();
        
        // Retrieve posted data
        $productId = $this->request->getPost('id');
        $cantidad = $this->request->getPost('cantidad');
        
        // Fetch product data from the database
        $producto = $productoModel->find($productId);
        if (!$producto) {
            return redirect()->to(base_url('catalogoDeProductos'))->with('mensaje', 'Producto no encontrado.');
        }
    
        // Check the available stock
        $stockDisponible = $producto['stock_producto'];
        
        $repetido = false;
        
        // Verify if the product already exists in the cart
        foreach ($sessionCart as &$cartItem) {
            if ($cartItem['id'] == $productId) {
                $newQuantity = $cartItem['qty'] + $cantidad;
                if ($newQuantity > $stockDisponible) {
                    return redirect()->to(base_url('ver_carrito'))->with('mensaje', 'No se puede añadir más de ' . $stockDisponible . ' unidades de este producto2.');
                }
                // Update the quantity in the session cart
                $cartItem['qty'] = $newQuantity;
                $repetido = true;
                break;
            }
        }
        
        // If the product is not in the cart, add it
        if (!$repetido) {
            if ($cantidad > $stockDisponible) {
                return redirect()->to(base_url('ver_carrito'))->with('mensaje', 'No se puede añadir más de ' . $stockDisponible . ' unidades de este producto.');
            }
    
            // Create a new item array
            $item = [
                'id'    => $productId,
                'name'  => $producto['nombre_producto'],
                'price' => $producto['precio_producto'],
                'qty'   => $cantidad,
            ];
            // Add the item to the session cart
            $sessionCart[] = $item;
        }
        
        // Update the session with the modified cart
        $this->session->set('cart', $sessionCart);
        
        // Use the cart service to update the actual cart contents
        foreach ($sessionCart as $item) {
            $cart->insert($item);
        }
        
        // Redirect to the catalog page with a success message
        return redirect()->to(base_url('catalogoDeProductos'))->with('mensaje', 'Producto añadido al carrito.');
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

    public function actualiza_carrito() {
        $session = session();
        $cart = \Config\Services::cart();
        $request = \Config\Services::request();
    
        $rowid = $request->getPost('id'); // Retrieve rowid from POST data
    
        // Log received rowid and POST data
        log_message('info', 'actualiza_carrito: Received rowid: ' . $rowid);
        log_message('info', 'actualiza_carrito: Received POST data: ' . json_encode($request->getPost()));
    
        // Check if the cart item exists
        $item = $cart->getItem($rowid);
        if (!$item) {
            log_message('error', 'actualiza_carrito: Item not found for rowid: ' . $rowid);
            return redirect()->back()->with('mensaje', 'Producto no encontrado en el carrito.');
        }
    
        $productoId = $item['id'];
        $stockDisponible = $this->obtenerStock($productoId);
        $qty = $request->getPost('qty');
    
        if ($qty < $stockDisponible) {
            $data = [
                'rowid' => $rowid,
                'qty'   => $qty,  // Accept quantity from user input
            ];
    
            // Log prepared data
            log_message('info', 'actualiza_carrito: Prepared data for cart update: ' . json_encode($data));
    
            // Validate input data
            if ($this->validateCartData($data)) {
                $cart->update($data);
                log_message('info', 'actualiza_carrito: Cart updated successfully.');
            } else {
                log_message('error', 'actualiza_carrito: Validation failed for data: ' . json_encode($data));
            }
            return redirect()->back();
        } else {
            log_message('error', 'actualiza_carrito: Insufficient stock for product ID: ' . $productoId);
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