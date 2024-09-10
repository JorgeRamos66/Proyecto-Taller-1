<?php
namespace App\Controllers;

use App\Models\Venta_Cabecera_Model;
use App\Models\Venta_Detalle_Model;
use App\Models\Categoria_Model;
use TCPDF;

class Factura_controller extends BaseController
{
    public function generarFactura($id) {
        require_once FCPATH . 'tcpdf/tcpdf.php'; // Incluir TCPDF

        $ventaCabeceraModel = new Venta_Cabecera_Model();
        $ventaDetalleModel = new Venta_Detalle_Model();
        $categoriaModel = new Categoria_Model(); // Instancia el modelo de categorías

        // Obtener datos de la venta
        $venta = $ventaCabeceraModel->getVentaConUsuario($id);
        if (!$venta) {
            throw new \Exception("Venta no encontrada.");
        }

        // Obtener detalles de la venta
        $detalles = $ventaDetalleModel->getDetalles($id);

        // Obtener categorías
        $categorias = $categoriaModel->getCategorias();
        $categoriaMap = [];
        foreach ($categorias as $categoria) {
            $categoriaMap[$categoria['id_categoria']] = $categoria['descripcion_categoria'];
        }

        // Crear el documento PDF
        $pdf = new TCPDF();

        // Establecer márgenes: izquierda, superior, derecha
        $pdf->SetMargins(5, 20, 5);

        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 12);

        // Título de la factura
        $pdf->Cell(0, 10, 'Factura', 0, 1, 'C');
        $pdf->Ln(10);

        // Fecha de factura
        $pdf->Cell(0, 10, 'Fecha de Factura: ' . date('d/m/Y', strtotime($venta['fecha'])), 0, 1, 'L');
        $pdf->Ln(5);

        // Nombre y Apellido del Cliente
        $pdf->Cell(0, 10, 'Nombre del Cliente: ' . $venta['nombre_usuario'] . ' ' . $venta['apellido_usuario'], 0, 1, 'L');
        $pdf->Ln(10);

        // Tabla de productos
        $pdf->SetFillColor(200, 220, 255);

        // Definir los anchos de las columnas
        $widths = [40, 60, 20, 40, 40];
        $pdf->Cell($widths[0], 10, 'Categoría', 1, 0, 'C', 1);
        $pdf->Cell($widths[1], 10, 'Nombre Producto', 1, 0, 'C', 1);
        $pdf->Cell($widths[2], 10, 'Cantidad', 1, 0, 'C', 1);
        $pdf->Cell($widths[3], 10, 'Precio Unitario', 1, 0, 'C', 1);
        $pdf->Cell($widths[4], 10, 'Subtotal', 1, 1, 'C', 1);

        $totalFactura = 0; // Variable para calcular el total de la factura

        foreach ($detalles as $detalle) {
            $categoriaNombre = isset($categoriaMap[$detalle['id_categoria']]) ? $categoriaMap[$detalle['id_categoria']] : 'Desconocido';

            // Utiliza el precio unitario correcto desde la tabla de productos
            $precioUnitario = $detalle['precio_producto'];
            $subtotal = $detalle['cantidad'] * $precioUnitario;
            $totalFactura += $subtotal;

            $pdf->Cell($widths[0], 10, $categoriaNombre, 1);
            $pdf->Cell($widths[1], 10, $detalle['nombre_producto'], 1);
            $pdf->Cell($widths[2], 10, $detalle['cantidad'], 1);
            $pdf->Cell($widths[3], 10, '$' . number_format($precioUnitario, 2), 1);
            $pdf->Cell($widths[4], 10, '$' . number_format($subtotal, 2), 1, 1);
        }

        $pdf->Ln(10);

        // Total
        $pdf->Cell(array_sum($widths) - 40, 10, 'Total', 1);
        $pdf->Cell($widths[4], 10, '$' . number_format($totalFactura, 2), 1, 1, 'R');

        // Enviar el PDF al navegador
        $pdf->Output('factura_' . $id . '.pdf', 'I');
        exit; // Asegurarse de que no haya salida adicional
    }
}
