<?php
session_start();
include_once __DIR__ . '/../Clases/Carrito.php';

// Indicamos al navegador que la respuesta será un objeto JSON
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'], $_POST['nombre_producto'])) {
    $id_prod = intval($_POST['id_producto']);
    $nombre_prod = htmlspecialchars($_POST['nombre_producto']);
    
    $miCarrito = new Carrito();
    $miCarrito->agregar($id_prod, $nombre_prod);
    
    // Calculamos el nuevo total global de unidades en el carrito
    $nuevoTotal = Carrito::obtenerTotalGlobal();
    
    // Obtenemos la lista actualizada de productos para el menú lateral
    $productosEnCarrito = $miCarrito->obtenerProductos();
    
    // Respondemos con éxito y mandamos los datos frescos
    echo json_encode([
        'status' => 'success',
        'nuevoTotal' => $nuevoTotal,
        'productos' => $productosEnCarrito
    ]);
    exit();
}

// Si entran de forma incorrecta
echo json_encode(['status' => 'error', 'message' => 'Petición inválida.']);