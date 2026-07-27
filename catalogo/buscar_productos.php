<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Repuestos</title>
    <link rel="stylesheet" href="catalogo.css">
    <link rel="stylesheet" href="../inicio/footer.css">
</head>
<body>
<?php
session_start(); 
include_once __DIR__ . '/../Clases/Carrito.php';
include_once __DIR__ . '/../Clases/conexion.php';
include_once __DIR__ . '/../Clases/Producto.php';
include_once __DIR__ . '/../Clases/Buscador.php'; 

$pdo = Cconexion::ConexionBD();
$miCarrito = new Carrito();

$totalItems = Carrito::obtenerTotalGlobal();
$productosEnCarrito = $miCarrito->obtenerProductos();

// Recibimos la subcategoría desde el JS (usando POST)
$sub = isset($_POST['subcategoria']) ? $_POST['subcategoria'] : null;

if ($sub && $pdo) {
    // Buscamos en la base de datos si coincide con la subcategoría o la categoría
    $sql = "SELECT * FROM productos WHERE sub_categoria = :sub OR categoria = :sub";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['sub' => $sub]);
    $productosBD = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($productosBD) { ?>
        <section id="catalogo-productos" class="contenedor-productos">
        
        <?php foreach ($productosBD as $fila) { 
            // Instanciamos el objeto producto pasando los 10 parámetros en el orden exacto de su constructor
            $prod = new producto(
                $fila['id'] ?? $fila['id_producto'],
                $fila['nombre'] ?? $fila['Nombre'],
                $fila['descripcion'] ?? $fila['Descripcion'],
                $fila['marca_producto'] ?? $fila['Marca_Producto'],
                $fila['marca_vehiculo'] ?? $fila['Marca_Vehiculo'],
                $fila['presentacion'] ?? $fila['Presentacion'],
                $fila['imagen_url'] ?? $fila['imagen_url'],
                $fila['referencia'] ?? $fila['referencia'],
                $fila['categoria'] ?? $fila['Categoria'],
                $fila['sub_categoria'] ?? $fila['Sub_Categoria']
            );
        ?>
            <div class="tarjeta-repuesto">
                <a href="../Producto/Producto.php?id=<?php echo $prod->Getid(); ?>"> 
                    <img src="<?php echo $prod->Getimagen_Url(); ?>" alt="<?php echo htmlspecialchars($prod->GetNombre()); ?>">
                </a>
                <div class="info-repuesto">
                    <h3 class="producto-titulo"><?php echo htmlspecialchars($prod->GetNombre()); ?></h3>
                    <p class="marca">Marca de carro: <?php echo htmlspecialchars($prod->GetMarca_Vehiculo()); ?></p>
                    <p class="tipo">Tipo: <?php echo htmlspecialchars($prod->GetCategoria()); ?></p>   
                    <div class="contenedor-btn">
                        <form onsubmit="agregarAlCarritoAsync(event, this.querySelector('.btn-comprar'))">
                            <input type="hidden" name="id_producto" value="<?php echo $prod->Getid(); ?>">
                            <input type="hidden" name="nombre_producto" value="<?php echo htmlspecialchars($prod->GetNombre()); ?>">
                            
                            <div class="card-acciones">
                                <a href="../Producto/Producto.php?id=<?php echo $prod->Getid(); ?>" class="btn-ver-mas">
                                    VER DETALLES
                                </a>
                            </div>
                        </form>
                    </div>
                </div>      
            </div> 
        <?php } ?>
        
        </section>
<?php
    } else {
        echo "<p style='color:white; padding: 20px; text-align:center;'>No hay productos disponibles para la subcategoría: " . htmlspecialchars($sub) . "</p>";
    }
} else {
    echo "<p style='color:white; padding: 20px; text-align:center;'>Error: No se seleccionó una subcategoría válida o no hay conexión con la base de datos.</p>";
}
?>
</body>
</html>