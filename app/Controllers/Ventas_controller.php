<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\Producto_Model;
use App\Models\Usuario_Model;
use App\Models\Venta_Cabecera_Model;
use App\Models\Venta_Detalle_Model;

class Ventas_controller extends Controller {
    public function __construct(){
        helper(['url', 'form']);
        $session = \Config\Services::session();
        //$session = session();
    }

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
        return redirect()->to(base_url('catalogoDeProductos'));
    }
    
    public function gestion_ventas()
    {
        helper(['url', 'form']);
        $ventasModel = new Venta_Cabecera_Model();
        $usuarioModel = new Usuario_Model();
    
        // Obtener la solicitud (request)
        /**
         * @var IncomingRequest $request 
         */
        $request = $this->request;
    
        // Parámetros para la paginación y búsqueda
        $itemsPerPage = $request->getVar('itemsPerPage') ? $request->getVar('itemsPerPage') : 5;
        $search = $request->getGet('search'); // Obtener el término de búsqueda
        $startDate = $request->getGet('startDate'); // Obtener la fecha de inicio
        $endDate = $request->getGet('endDate'); // Obtener la fecha de fin
    
        // Inicializar la consulta base con JOIN para obtener el nombre del usuario
        $ventasQuery = $ventasModel
            ->select('ventas_cabecera.id_ventas_cabecera, ventas_cabecera.total_venta, ventas_cabecera.fecha, usuarios.usuario')
            ->join('usuarios', 'usuarios.id_usuario = ventas_cabecera.usuario_id');
    
        // Aplicar filtro de búsqueda si existe
        if ($search) {
            $ventasQuery->like('usuarios.usuario', $search);
        }
    
        // Aplicar filtros de fechas si se seleccionaron
        if ($startDate && $endDate) {
            // Convertir fechas al formato correcto para la consulta
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
    
        // Paginar los resultados
        $ventas = $ventasQuery->paginate($itemsPerPage, 'ventas');
    
        // Verificar errores de la consulta
        if ($ventasModel->errors()) {
            // Muestra los errores en el log o puedes mostrarlos en la vista para depuración
            log_message('error', 'Errores en la consulta: ' . print_r($ventasModel->errors(), true));
        }
    
        $pager = $ventasModel->pager;
        $pager->setPath('gestion_ventas'); // Establecer la ruta base para la paginación
    
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
            // Obtener el nombre del producto
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