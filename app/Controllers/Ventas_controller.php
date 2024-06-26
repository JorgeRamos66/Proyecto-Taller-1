<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Producto_Model;
use App\Models\Usuario_Model;
use App\Models\Venta_Cabecera_Model;
use App\Models\Venta_Detalle_Model;

class Ventas_controller extends Controller {

    public function registrar_venta() {
        $session = session();

        $cart = $session->get('cart') ?? [];

        if (empty($cart)) {
            $session->setFlashdata('mensaje', 'No hay productos en el carrito para confirmar la orden.');
            return redirect()->to(base_url('catalogoDeProductos'));
        }

        $ventas = new Venta_Cabecera_Model();
        $detalleventas = new Venta_Detalle_Model();
        $producto = new Producto_Model();
        $usuario = new Usuario_Model();

        // Calculate total
        $total = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0);

        // Insert into ventas_cabecera
        $nueva_venta = [
            'usuario_id' => $session->get('id_usuario'),
            'total_venta' => $total,
            'fecha' => date('Y-m-d H:i:s')
        ];
        $venta_id = $ventas->insert($nueva_venta);

        // Insert into ventas_detalle
        foreach ($cart as $item) {
            $detalle = [
                'venta_id' => $venta_id,
                'producto_id' => $item['id'],
                'cantidad' => $item['qty'],
                'precio' => $item['price'] * $item['qty']
            ];

            // Check stock availability
            $producto_actual = $producto->find($item['id']);
            if ($producto_actual['stock_producto'] >= $item['qty']) {
                $detalleventas->insert($detalle);
                // Update stock
                $producto->updateStock($item['id'], $producto_actual['stock_producto'] - $item['qty']);
            } else {
                $session->setFlashdata('mensaje', 'No hay suficiente stock disponible para el producto "' . $producto_actual['nombre_producto'] . '".');
                return redirect()->to(base_url('catalogoDeProductos'));
            }
        }

        // Clear cart after successful order
        $session->remove('cart');
        $session->setFlashdata('mensaje', 'Venta registrada exitosamente.');
        return redirect()->to(base_url('vista_compras/' . $venta_id));
    }

    public function ver_factura($venta_id) {
        $detalleventas = new Venta_Detalle_Model();
        $data['venta'] = $detalleventas->getDetalles($venta_id);
        $data['titulo'] = "Mi compra";

        return view('proyecto/front/Encabezado', $data)
            . view('proyecto/front/Barra_de_navegacion')
            . view('proyecto/back/Vista_compras')
            . view('proyecto/front/Pie_de_pagina');
    }

    public function ver_facturas_usuario($id_usuario) {
        $ventas = new Venta_Cabecera_Model();
        $data['ventas'] = $ventas->getVentas($id_usuario);
        $data['titulo'] = "Todos mis compras";

        return view('proyecto/front/Encabezado', $data)
            . view('proyecto/front/Barra_de_navegacion')
            . view('proyecto/back/Vista_factura_usuario')
            . view('proyecto/front/Pie_de_pagina');
    }

}