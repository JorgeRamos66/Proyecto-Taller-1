<?php

namespace App\Controllers;
Use App\Models\Producto_Model;
use CodeIgniter\Session\Session;
use CodeIgniter\Controller;
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
    public function ver_carrito()
    {
        $cart = $this->session->get('cart') ?? [];
        $productoModel = new Producto_Model();

        foreach ($cart as &$item) {
            $producto = $productoModel->find($item['id']);
            $item['producto'] = $producto ? $producto : null;
        }

        $data = [
            'titulo' => 'Carrito de Compras',
            'cart' => $cart,
        ];

        return view('proyecto/front/Encabezado', $data)
            . view('proyecto/front/Barra_de_navegacion')
            . view('proyecto/back/Carrito', $data)
            . view('proyecto/front/Pie_de_pagina');
    }

    public function agregar_al_carrito() {
        // Obtén el servicio de sesión y el carrito
        $session = session();
        $cart = $session->get('cart') ?? [];
    
        // Obtén los datos del producto a agregar desde el formulario
        $productId = $this->request->getPost('id');
        $nombre_producto = $this->request->getPost('nombre_producto');
        $precio = $this->request->getPost('precio');
        $cantidad = $this->request->getPost('cantidad');
    
        // Verifica el stock disponible para el nuevo producto
        $stockDisponible = $this->obtenerStock($productId);
    
        // Si la cantidad solicitada es mayor al stock disponible, muestra un mensaje de error
        if ($cantidad > $stockDisponible) {
            return redirect()->to(base_url('catalogoDeProductos'))->with('mensaje', 'No hay suficiente stock disponible para este producto.');
        }
    
        // Busca si el producto ya está en el carrito
        $producto_existente = false;
        foreach ($cart as $index => $item) {
            if ($item['id'] == $productId) {
                // Si el producto ya está en el carrito, incrementa la cantidad utilizando la función incrementarProducto
                $this->incrementar_producto($index);
                $producto_existente = true;
                break;
            }
        }
    
        // Si el producto no está en el carrito, agrégalo como un nuevo ítem
        if (!$producto_existente) {
            $producto = [
                'id' => $productId,
                'name' => $nombre_producto, // Asegúrate de cambiar 'name' según la estructura de tu carrito
                'price' => $precio,
                'qty' => $cantidad,
            ];
            $cart[] = $producto;
            $session->set('cart', $cart);
        }
    
        // Redirecciona de vuelta al carrito después de agregar el producto
        return redirect()->to(base_url('catalogoDeProductos'))->with('mensaje', 'Producto añadido al carrito.');
    }
    public function incrementar_producto($index)
    {
        $cart = $this->session->get('cart');

        if (isset($cart[$index])) {
            $productId = $cart[$index]['id'];
            $stockDisponible = $this->obtenerStock($productId);

            if ($cart[$index]['qty'] < $stockDisponible) {
                $cart[$index]['qty']++;
                $this->session->set('cart', $cart);
            } else {
                return redirect()->back()->with('mensaje', 'Esta superando el stock máximo en esta compra.');
            }
        } else {
            return redirect()->back()->with('mensaje', 'Índice de producto no válido.');
        }

        return redirect()->back();
    }

    public function decrementar_producto($index)
    {
        $cart = $this->session->get('cart');

        // Verifica si el índice proporcionado está dentro del rango válido para el carrito
        if (isset($cart[$index])) {
            // El límite de decremento es 1 (no se puede tener menos de 1 producto en el carrito)
            if ($cart[$index]['qty'] > 1) {
                $cart[$index]['qty']--;
                $this->session->set('cart', $cart);
            } else {
                return redirect()->back()->with('mensaje', 'No se pueden establecer cantidades inferiores a una unidad. Si desea eliminar el producto, presione "Eliminar".');
            }
        } else {
            return redirect()->back()->with('mensaje', 'Índice de producto no válido.');
        }

        return redirect()->back();
    }


    public function borrar_del_carrito($index)
    {
        $cart = $this->session->get('cart');

        if (isset($cart[$index])) {
            unset($cart[$index]);
            $this->session->set('cart', array_values($cart));
        }

        return redirect()->to('ver_carrito');
    }

    public function vaciar_carrito()
    {
        $this->session->remove('cart');
        return redirect()->back()->with('mensaje', 'Carrito vaciado.');
    }

    
    
    public function obtenerStock($id_producto)
    {
        $productoModel = new Producto_Model();
        $producto = $productoModel->find($id_producto);

        if ($producto) {
            return $producto['stock_producto'];
        } else {
            return 0;
        }
    }


    public function devolver_carrito() {
        $cart = \Config\Services::cart();  
        return $cart->contents(); // Return cart contents
    }
    public function verificar_carrito()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        return $this->response->setJSON(['empty' => empty($cart)]);
    }

    private function validateCartData($data) {
        // Validar que todos los campos requeridos están presentes
        return isset($data['id'], $data['qty'], $data['price'], $data['name']) &&
               is_numeric($data['price']) && is_numeric($data['qty']);
    }
    
}