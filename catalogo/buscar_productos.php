<?php
// 1. La sesión y lógica PHP DEBEN ir al puro inicio antes de cualquier salida visual
session_start(); 

include_once __DIR__ . '/../Clases/conexion.php';
include_once __DIR__ . '/../Clases/Producto.php';

$pdo = Cconexion::ConexionBD();

// Capturamos el parámetro enviado desde el JavaScript por POST
$sub = isset($_POST['subcategoria']) ? trim($_POST['subcategoria']) : null;

if (!$sub || !$pdo) {
    echo "<p style='color:#fff; text-align:center; padding: 20px; grid-column: 1 / -1;'>No se especificó ninguna categoría o hubo un error de conexión.</p>";
    exit();
}

// 2. Consulta optimizada a la BD
$sql = "SELECT * FROM productos WHERE sub_categoria = :sub OR categoria = :sub";
$stmt = $pdo->prepare($sql);
$stmt->execute(['sub' => $sub]);
$productosBD = $stmt->fetchAll(PDO::FETCH_ASSOC);

// 3. Renderizado del Fragmento HTML (Se inyectará directamente en #catalogo-productos)
if (empty($productosBD)): ?>
    <p style="color:#fff; text-align:center; padding: 40px; grid-column: 1 / -1;">
        No hay repuestos disponibles para la categoría: <strong><?php echo htmlspecialchars($sub); ?></strong>
    </p>
<?php else: ?>
    <?php foreach ($productosBD as $fila): 
        // Instanciamos el objeto Producto con los datos retornados por la BD
        $prod = new Producto(
            $fila['id'] ?? $fila['id_producto'],
            $fila['grupo'] ?? $fila['grupo_id'],
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
            <a href="/Producto/Producto.php?id=<?php echo $prod->GetId(); ?>"> 
                <img src="<?php echo htmlspecialchars($prod->GetImagen_Url()); ?>" alt="<?php echo htmlspecialchars($prod->GetNombre()); ?>">
            </a>
            <div class="info-repuesto">
                <div class="producto-titulo">    
                    <h3><?php echo htmlspecialchars($prod->GetNombre()); ?></h3>
                </div>
                <p class="marca">Referencia: <?php echo htmlspecialchars($prod->GetReferencia()); ?></p>   
                <p class="marca">Marca: <?php echo htmlspecialchars($prod->GetMarca_Producto()); ?></p>    
                
                <div class="contenedor-btn">
                    <a href="/Producto/Producto.php?id=<?php echo $prod->GetId(); ?>" class="btn-ver-mas">
                        VER DETALLES
                    </a>
                </div>
            </div>       
        </div>
    <?php endforeach; ?>
<?php endif; ?>