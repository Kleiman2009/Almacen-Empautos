<?php

class Carrito {
    
    // 1. Declaramos la variable estática para almacenar el total acumulado
    protected static $totalProductos = 0;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['carrito'])) {
            $_SESSION['carrito'] = [];
        }
        
        // 2. Cada vez que se instancia el carrito, calculamos el total inicial
        self::calcularTotalEstatico();
    }

    /**
     * [NUEVO] Método privado que recorre el array de la sesión 
     * y asigna la suma a la variable estática.
     */
    private static function calcularTotalEstatico() {
        self::$totalProductos = 0; // Reiniciamos la cuenta
        
        if (isset($_SESSION['carrito'])) {
            foreach ($_SESSION['carrito'] as $item) {
                // Sumamos las cantidades de cada repuesto
                self::$totalProductos += $item['cantidad'];
            }
        }
    }

    public function agregar($id, $nombre) {
        if (isset($_SESSION['carrito'][$id])) {
            $_SESSION['carrito'][$id]['cantidad']++;
        } else {
            $_SESSION['carrito'][$id] = [
                'id'       => $id,
                'nombre'   => $nombre,
                'cantidad' => 1
            ];
        }
        
        // 3. Recalculamos el total estático inmediatamente después de agregar un producto
        self::calcularTotalEstatico();
    }

    public function obtenerProductos() {
        return $_SESSION['carrito'] ?? [];
    }

    /**
     * 4. [NUEVO] Método estático para obtener el valor de la variable estática
     * Desde fuera de la clase se llamará como: Carrito::obtenerTotalGlobal()
     */
    
    public static function obtenerTotalGlobal() {
    // Si no hay sesión o el carrito está completamente vacío, devolvemos 0
    if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
        return 0;
    }

    $totalUnidades = 0;

    // Recorremos cada repuesto guardado en la sesión
    foreach ($_SESSION['carrito'] as $item) {
        // Sumamos la cantidad real de cada repuesto (ej: si son 17 del mismo, suma 17)
        if (is_array($item) && isset($item['cantidad'])) {
            $totalUnidades += intval($item['cantidad']);
        }
    }

    return $totalUnidades;
}

public function quitar($id_producto) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    $id_producto = intval($id_producto);

    // Si el producto existe en el carrito de la sesión, lo borramos
    if (isset($_SESSION['carrito'][$id_producto])) {
        unset($_SESSION['carrito'][$id_producto]);
        return true;
    }
    
    return false;
}
}