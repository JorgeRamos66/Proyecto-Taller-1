<?php

namespace App\Controllers;

use App\Models\Producto_Model;
use CodeIgniter\Controller;

class Carrito_controller extends BaseController
{
    public function __construct()
    {
        helper(['form', 'url', 'cart']);
    }

    // Ver el carrito
    public function ver_carrito()
    {
        // Obtén los datos del carrito desde la sesión
        $session = session();
        $data['cartItems'] = $session->get('cart') ?? [];
        $data['titulo'] = "Carrito de compras";

        return view('proyecto/front/Encabezado', $data)
            . view('proyecto/front/Barra_de_navegacion')
            . view('proyecto/back/Carrito', $data)
            . view('proyecto/front/Pie_de_pagina');
    }

    // Agregar producto al carrito
    public function agregar_al_carrito()
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        // Obtén los datos del producto a agregar desde el formulario
        $productId = $this->request->getPost('id');
        $nombre_producto = $this->request->getPost('nombre_producto');
        $precio = $this->request->getPost('precio');
        $cantidad = $this->request->getPost('cantidad');

        // Verifica el stock disponible para el nuevo producto
        $stockDisponible = $this->obtenerStock($productId);

        if ($cantidad > $stockDisponible) {
            return redirect()->to(base_url('catalogoDeProductos'))->with('mensaje', 'No hay suficiente stock disponible para este producto.');
        }

        // Busca si el producto ya está en el carrito
        $producto_existente = false;
        foreach ($cart as $index => $item) {
            if ($item['id'] == $productId) {
                // Solo actualiza la cantidad en el carrito si hay suficiente stock
                if (($item['qty'] + $cantidad) <= $stockDisponible) {
                    $cart[$index]['qty'] += $cantidad;
                } else {
                    return redirect()->to(base_url('catalogoDeProductos'))->with('mensaje', 'No hay suficiente stock disponible para este producto.');
                }
                $producto_existente = true;
                break;
            }
        }

        // Si el producto no está en el carrito, agrégalo como un nuevo ítem
        if (!$producto_existente) {
            $producto = [
                'id' => $productId,
                'name' => $nombre_producto,
                'price' => $precio,
                'qty' => $cantidad,
            ];
            $cart[] = $producto;
        }
        
        $session->set('cart', $cart);

        return redirect()->to(base_url('catalogoDeProductos'))->with('mensaje', 'Producto añadido al carrito.');
    }

    // Incrementar producto en el carrito
    public function incrementar_producto($index)
    {
        $session = session();
        $cart = $session->get('cart');

        if (isset($cart[$index])) {
            $productId = $cart[$index]['id'];
            $stockDisponible = $this->obtenerStock($productId);

            if ($cart[$index]['qty'] < $stockDisponible) {
                $cart[$index]['qty']++;
                $session->set('cart', $cart);
            } else {
                return redirect()->back()->with('mensaje', 'Está superando el stock máximo en esta compra.');
            }
        } else {
            return redirect()->back()->with('mensaje', 'Índice de producto no válido.');
        }

        return redirect()->back();
    }

    // Decrementar producto en el carrito
    public function decrementar_producto($index)
    {
        $session = session();
        $cart = $session->get('cart');

        if (isset($cart[$index])) {
            if ($cart[$index]['qty'] > 1) {
                $cart[$index]['qty']--;
                $session->set('cart', $cart);
            } else {
                return redirect()->back()->with('mensaje', 'No se pueden establecer cantidades inferiores a una unidad. Si desea eliminar el producto, presione "Eliminar".');
            }
        } else {
            return redirect()->back()->with('mensaje', 'Índice de producto no válido.');
        }

        return redirect()->back();
    }

    // Borrar producto del carrito
    public function borrar_del_carrito($index)
    {
        $session = session();
        $cart = $session->get('cart');

        if (isset($cart[$index])) {
            unset($cart[$index]);
            $session->set('cart', array_values($cart));
        }

        return redirect()->to(base_url('ver_carrito'));
    }

    // Vaciar el carrito
    public function vaciar_carrito()
    {
        $session = session();
        $session->remove('cart');
        return redirect()->back()->with('mensaje', 'Carrito vaciado.');
    }

    // Obtener stock del producto
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

    // Verificar si el carrito está vacío
    public function verificar_carrito()
    {
        $session = session();
        $cartItems = $session->get('cart') ?? [];

        // Cambiar la respuesta a la clave 'hasItems' que es lo que el script espera
        if (empty($cartItems)) {
            return $this->response->setJSON(['hasItems' => false]);
        } else {
            return $this->response->setJSON(['hasItems' => true]);
        }
    }
}
