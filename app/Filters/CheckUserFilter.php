<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class CheckUserFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Obtener todos los segmentos de la URL
        $segments = $request->getUri()->getSegments();
        
        // Capturar el ID codificado (segundo segmento en la URL)
        $encodedUserId = $segments[1] ?? null;

        // Verificar si el ID codificado es válido
        if (!$encodedUserId) {
            return redirect()->back()->with('msj', 'ID de usuario no encontrado en la URL.');
        }

        // Decodificar el ID de base64 y convertirlo a entero
        $userId = (int) base64_decode($encodedUserId);

        // Verificar si el ID decodificado no está vacío y es numérico
        if (!$userId || !is_numeric($userId)) {
            return redirect()->back()->with('msj', 'ID de usuario no válido en la URL.');
        }

        // Obtener el ID del usuario autenticado desde la sesión y convertirlo a entero
        $loggedUserId = (int) session()->get('id_usuario');


        // Verificar si el usuario intenta acceder a su propio perfil
        if ($userId !== $loggedUserId) {
            // Redirigir si el usuario intenta acceder a un perfil que no es el suyo
            return redirect()->back()->with('msj', 'No tienes permiso para acceder a este perfil.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}