<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Producto_Model;
use App\Models\Usuario_Model;
use App\Models\Venta_Cabecera_Model;
use App\Models\Venta_Detalle_Model;

class Ventas_controller extends BaseController {
    public function __construct(){
        helper(['url', 'form']);
        $session = \Config\Services::session();
    }

    public function registrar_venta() {
        $session = session();
        $cart = $session->get('cart') ?? [];
        
        if (empty($cart)) {
            return $this->response->setJSON(['success' => false, 'message' => 'No hay productos en el carrito para confirmar la orden.']);
        }
    
        $ventas = new Venta_Cabecera_Model();
        $detalleventas = new Venta_Detalle_Model();
        $producto = new Producto_Model();
        
        // Obtener datos del POST
        $paymentMethod = $this->request->getPost('paymentMethod');
        $deliveryMethod = $this->request->getPost('deliveryMethod');
        $address = $this->request->getPost('address');
        
        
        
        // Calcular total
        $total = array_reduce($cart, function($carry, $item) {
            return $carry + ($item['price'] * $item['qty']);
        }, 0);
        
        // Verificar disponibilidad de stock antes de insertar la venta
        foreach ($cart as $item) {
            $producto_actual = $producto->find($item['id']);
            if ($producto_actual['stock_producto'] < $item['qty']) {
                return $this->response->setJSON(['success' => false, 'message' => 'No hay suficiente stock disponible para el producto "' . $producto_actual['nombre_producto'] . '".']);
            }
        }
        
        // Insertar en ventas_cabecera
        $nueva_venta = [
            'usuario_id' => $session->get('id_usuario'),
            'total_venta' => $total,
            'fecha' => date('Y-m-d H:i:s'),
            'payment_method' => $paymentMethod,
            'delivery_method' => $deliveryMethod,
            'address' => $deliveryMethod === 'delivery' ? $address : null
        ];
        $venta_id = $ventas->insert($nueva_venta);
        
        // Insertar en ventas_detalle y actualizar stock
        foreach ($cart as $item) {
            $detalle = [
                'venta_id' => $venta_id,
                'producto_id' => $item['id'],
                'cantidad' => $item['qty'],
                'precio' => $item['price'] * $item['qty']
            ];
    
            $detalleventas->insert($detalle);
            // Actualizar stock
            $producto_actual = $producto->find($item['id']);
            $nuevo_stock = $producto_actual['stock_producto'] - $item['qty'];
            $producto->update($item['id'], ['stock_producto' => $nuevo_stock]);
        }
        
        // Limpiar carrito después de una orden exitosa
        $session->remove('cart');
        
        return redirect()->to(base_url('catalogoDeProductos'))->with('mensaje', 'Compra realizada con exito!');
    }
    
    public function gestion_ventas()
    {
        helper(['url', 'form']);
        $ventasModel = new Venta_Cabecera_Model();
        $usuarioModel = new Usuario_Model();
    
        $request = $this->request;
    
        $itemsPerPage = $request->getVar('itemsPerPage') ? $request->getVar('itemsPerPage') : 5;
        $search = $request->getGet('search');
        $startDate = $request->getGet('startDate');
        $endDate = $request->getGet('endDate');
    
        $ventasQuery = $ventasModel
            ->select('ventas_cabecera.id_ventas_cabecera, ventas_cabecera.total_venta, ventas_cabecera.fecha, usuarios.usuario')
            ->join('usuarios', 'usuarios.id_usuario = ventas_cabecera.usuario_id');
    
        if ($search) {
            $ventasQuery->like('usuarios.usuario', $search);
        }
    
        if ($startDate && $endDate) {
            $startDateFormatted = date('Y-m-d 00:00:00', strtotime($startDate));
            $endDateFormatted = date('Y-m-d 23:59:59', strtotime($endDate));
            $ventasQuery->where('ventas_cabecera.fecha >=', $startDateFormatted)
                        ->where('ventas_cabecera.fecha <=', $endDateFormatted);
        } elseif ($startDate) {
            $startDateFormatted = date('Y-m-d 00:00:00', strtotime($startDate));
            $ventasQuery->where('ventas_cabecera.fecha >=', $startDateFormatted);
        } elseif ($endDate) {
            $endDateFormatted = date('Y-m-d 23:59:59', strtotime($endDate));
            $ventasQuery->where('ventas_cabecera.fecha <=', $endDateFormatted);
        }
    
        $ventas = $ventasQuery->paginate($itemsPerPage, 'ventas');
    
        if ($ventasModel->errors()) {
            log_message('error', 'Errores en la consulta: ' . print_r($ventasModel->errors(), true));
        }
    
        $pager = $ventasModel->pager;
        $pager->setPath('gestion_ventas');
    
        $data = [
            'ventas' => $ventas,
            'pager' => $pager,
            'itemsPerPage' => $itemsPerPage,
            'search' => $search,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'titulo' => 'Gestión de Ventas',
        ];
    
        return view('proyecto/front/Encabezado', $data)
               . view('proyecto/front/Barra_de_navegacion_admin')
               . view('proyecto/back/Ventas', $data)
               . view('proyecto/front/Pie_de_pagina');
    }

    public function gestion_facturacion()
    {
        helper(['url', 'form']);
        $ventasModel = new Venta_Cabecera_Model();
        $usuarioModel = new Usuario_Model();

        $request = $this->request;

        // Configurar el número de ítems por página
        $itemsPerPage = $request->getVar('itemsPerPage') ? $request->getVar('itemsPerPage') : 5;
        $search = $request->getGet('search');
        $startDate = $request->getGet('startDate');
        $endDate = $request->getGet('endDate');

        // Construir la consulta
        $ventasQuery = $ventasModel
            ->select('ventas_cabecera.id_ventas_cabecera, ventas_cabecera.total_venta, ventas_cabecera.fecha, usuarios.nombre, usuarios.apellido')
            ->join('usuarios', 'usuarios.id_usuario = ventas_cabecera.usuario_id');

        // Aplicar filtros de búsqueda
        if ($search) {
            $ventasQuery->groupStart()
                ->like('ventas_cabecera.id_ventas_cabecera', $search)
                ->orLike('usuarios.nombre', $search)
                ->orLike('usuarios.apellido', $search)
                ->groupEnd();
        }
        

        if ($startDate && $endDate) {
            $startDateFormatted = date('Y-m-d 00:00:00', strtotime($startDate));
            $endDateFormatted = date('Y-m-d 23:59:59', strtotime($endDate));
            $ventasQuery->where('ventas_cabecera.fecha >=', $startDateFormatted)
                        ->where('ventas_cabecera.fecha <=', $endDateFormatted);
        } elseif ($startDate) {
            $startDateFormatted = date('Y-m-d 00:00:00', strtotime($startDate));
            $ventasQuery->where('ventas_cabecera.fecha >=', $startDateFormatted);
        } elseif ($endDate) {
            $endDateFormatted = date('Y-m-d 23:59:59', strtotime($endDate));
            $ventasQuery->where('ventas_cabecera.fecha <=', $endDateFormatted);
        }

        // Obtener las facturas paginadas
        $ventas = $ventasQuery->paginate($itemsPerPage, 'facturacion');

        if ($ventasModel->errors()) {
            log_message('error', 'Errores en la consulta: ' . print_r($ventasModel->errors(), true));
        }

        $pager = $ventasModel->pager;
        $pager->setPath('gestion_facturacion');

        // Pasar datos a la vista
        $data = [
            'ventas' => $ventas,
            'pager' => $pager,
            'itemsPerPage' => $itemsPerPage,
            'search' => $search,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'titulo' => 'Gestión de Facturación',
        ];

        return view('proyecto/front/Encabezado', $data)
            . view('proyecto/front/Barra_de_navegacion_admin')
            . view('proyecto/back/Facturacion', $data)
            . view('proyecto/front/Pie_de_pagina');
    }
    
    public function ver_factura($venta_id) {
        $detalleventas = new Venta_Detalle_Model();
        $ventaDetalles = $detalleventas->getDetalles($venta_id);
    
        $data = [
            'venta' => $ventaDetalles
        ];
    
        return $this->response->setJSON($data);
    }

    public function obtener_detalle_venta($venta_id) {
        $detalleventas = new Venta_Detalle_Model();
        $detalles = $detalleventas->getDetalles($venta_id);
        $productoModel = new Producto_Model();
    
        $result = [];
        foreach ($detalles as $detalle) {
            $producto = $productoModel->find($detalle['producto_id']);

            $result[] = [
                'nombre_producto' => $producto['nombre_producto'],
                'cantidad' => $detalle['cantidad'],
                'precio_unitario' => number_format($detalle['precio'] / $detalle['cantidad'], 2),
                'total' => number_format($detalle['precio'], 2),
            ];
        }
    
        return $this->response->setJSON(['detalles' => $result]);
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
