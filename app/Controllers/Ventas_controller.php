<?php
namespace App\Controllers;
use CodeIgniter\Controller;
Use App\Models\Producto_model;
Use App\Models\Usuarios_model;
Use App\Models\Venta_Cabecera_Model;
Use App\Models\Venta_Detalle_Model;

class Ventas_controller extends Controller{

    public function registrar_venta()
    {
         $session = session();

         require(APPPATH . 'Controllers/Carrito_controller.php');
        //hago esto porque tengo que traer el contenido del carrito desde el controlador.
          $cart = new carrito_controller();
          $carrito_contents = $cart->devolver_carrito(); //función dentro de carrito_controller 
       
          $ventas = new Venta_Cabecera_Model();
          $detalleventas = new Venta_Detalle_Model();
          $producto = new Producto_model();
          
       //recorro el carrito de compras para calcular el total
        $total = 0;
        foreach ($carrito_contents as $row) {
            $total += $row['subtotal'];
        }
        // guardo la venta en un array
        $nueva_venta = [
           'usuario_id' => $session->get('id_usuario'),
           'total_venta' => $total
        ];
        $venta_id = $ventas->insert($nueva_venta); //inserta en la tabla (ventas_cabecera)
       
        foreach ($carrito_contents as $row) {
            $detalle = array(
                'venta_id' => $venta_id,
                'producto_id' => $row['id'],
                'cantidad' => $row['qty'],
                'precio' => $row['subtotal']
            );
             //pasamos el id del producto al modelo método getProducto() para que me recupere ese registro con ese id
            $producto_actual = $producto->getProducto($row['id']);
        
          if($producto_actual['stock'] >= $row['qty']){
               $detalleventas->insert($detalle);//guarda el detalle en tabla ventas_detalle
                 //actualiza el stock
              $producto->updateStock($row['id'], $producto_actual['stock'] - $row['qty']);
           }else{
                $session->setFlashdata('mensaje', 'No hay stock disponible para el producto "'.$row['name'].'"');
                 return redirect()->to(base_url('muestro'));
            }
          }
        $cart->remover_del_carrito('all');
        $session =session();
        $session->setFlashdata('mensaje', "Venta registrada Exitosamente");
        return redirect()->to(base_url('vista_compras/'. $venta_id));
    }

  //función del usuario cliente para ver sus compras
    public function ver_factura($venta_id)
    {
         //echo $venta_id;die;
        $detalle_ventas = new Venta_Detalle_Model();
        $data['venta'] = $detalle_ventas->getDetalles($venta_id);
        
        $data['titulo'] = "Mi compra";
          

        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/back/Vista_compras')
        .view('proyecto/front/Pie_de_pagina');
    }
     //función del cliente para ver el detalle de su facturas de compras
      public function ver_facturas_usuario($id_usuario){
       
        $ventas = new Venta_Cabecera_Model;
           
        $data['ventas'] = $ventas->getVentas($id_usuario);
        $dato['titulo'] = "Todos mis compras";
            
        return view('proyecto/front/Encabezado', $data)
        .view('proyecto/front/Barra_de_navegacion')
        .view('proyecto/back/Vista_factura_usuario')
        .view('proyecto/front/Pie_de_pagina');
    }

}