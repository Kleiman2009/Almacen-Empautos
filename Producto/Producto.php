<?php
session_start(); 
include_once __DIR__ . '/../Clases/Carrito.php';
include_once __DIR__ . '/../Clases/conexion.php';
include_once __DIR__ . '/../Clases/Producto.php';
include_once __DIR__ . '/../Clases/Buscador.php'; 

$repuesto = null;
$id_a_buscar = isset($_GET['id']) ? intval($_GET['id']) : 0;

if (!$id_a_buscar) {
    die("Error: No se especificó un ID de producto válido.");
}

$pdo = Cconexion::ConexionBD(); 
if ($pdo !== null) {
    $repuesto = Producto::buscarPorId($id_a_buscar, $pdo);
}

$miCarrito = new Carrito();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'quitar_item') {
    $id_a_quitar = intval($_POST['id_producto_quitar']);
    $miCarrito->quitar($id_a_quitar);
    
    $pagina_actual = basename($_SERVER['PHP_SELF']);
    if ($pagina_actual === 'Producto.php' && isset($_GET['id'])) {
        header("Location: Producto.php?id=" . intval($_GET['id']));
    } else {
        header("Location: Catalogo.php");
    }
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_prod = intval($_POST['id_producto']);
    $nombre_prod = htmlspecialchars($_POST['nombre_producto']);
    
    $miCarrito->agregar($id_prod, $nombre_prod);
    
    echo "<script>window.location.replace('Producto.php?id=" . $id_prod . "');</script>";
    exit();
}

$id_actual = isset($_GET['id']) ? intval($_GET['id']) : 0;

$variantes = [];
if ($repuesto) {
    $ref_actual = trim($repuesto->GetReferencia());
    $stmt_var = $pdo->prepare("SELECT id, presentacion FROM productos WHERE grupo_id = (SELECT grupo_id FROM productos WHERE id = :id_actual) AND grupo_id IS NOT NULL");
    $stmt_var->execute(['id_actual' => $id_actual]);
    $variantes = $stmt_var->fetchAll(PDO::FETCH_ASSOC);
}

$query_specs = "SELECT caracteristica AS nombre_caracteristica, valor FROM producto_caracteristicas WHERE producto_id = :id";
$stmt_specs = $pdo->prepare($query_specs);
$stmt_specs->execute(['id' => $id_actual]);
$lista_especificaciones = $stmt_specs->fetchAll(PDO::FETCH_ASSOC);

$lista_imagenes = ($pdo !== null && $id_a_buscar > 0) ? Producto::obtenerImagenesPorId($id_a_buscar, $pdo) : [];
if (empty($lista_imagenes) && $repuesto) {
    $lista_imagenes[] = $repuesto->Getimagen_Url();
}

$totalItems = Carrito::obtenerTotalGlobal();
$termino = htmlspecialchars($_GET["q"] ?? "");
$listaProductos = Buscador::buscarPorNombre($termino, $pdo);
$productosEnCarrito = $miCarrito->obtenerProductos();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $repuesto ? htmlspecialchars($repuesto->GetNombre()) : 'Producto'; ?> - Repuestos Malagón</title>
    <link rel="stylesheet" href="Producto.css">
</head>
<body>

<header> 
    <a href="/index.php" class="cajalogo">
        <img class="logo" src="/../img/Multimedia/logo.png" alt="logo">
    </a>

    <a id="carrito" class="carrito" href="javascript:void(0)" onclick="toggleCarrito()">
        <img class="carritoimg" src="/../img/Multimedia/carrito.svg" alt="carrito">
        <span id="contador-carrito"><?php echo $totalItems; ?></span>
    </a>

    <div id="menu-carrito" class="menu-lateral"> 
        <div class="menu-header">
            <h2>Mi Carrito</h2>
            <button class="btn-cerrar" onclick="toggleCarrito()">&times;</button>
        </div>
        <div class="menu-body">
            <div id="contenido-carrito">
                <?php if (empty($productosEnCarrito)):?>
                    <p class="carrito-vacio-msg">El carrito está vacío.</p>
                <?php else: ?>
                    <?php foreach ($productosEnCarrito as $id => $item): ?>
                        <div class="item-carrito">
                            <div>
                                <strong><?php echo htmlspecialchars($item['nombre'] ?? $item['Nombre'] ?? 'Repuesto'); ?></strong><br>
                                <span class="cantidad-item">Cantidad: <?php echo $item['cantidad'] ?? $item['Cantidad'] ?? 1; ?></span>
                            </div>          
                            <form method="POST" action="">
                                <input type="hidden" name="action" value="quitar_item">
                                <input type="hidden" name="id_producto_quitar" value="<?php echo $id; ?>">
                                <button type="submit" class="btn-eliminar-item" title="Quitar del carrito">&times;</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="menu-footer">
            <?php 
                $jsonProductos = !empty($productosEnCarrito) ? base64_encode(json_encode($productosEnCarrito)) : base64_encode(json_encode([]));
            ?>
            <button 
                onclick="enviarWhatsApp(this)" 
                class="btn-finalizar" 
                id="finalizar-compra" 
                data-productos="<?php echo $jsonProductos; ?>">
                Finalizar Compra por WhatsApp
            </button>
        </div>
    </div>      
</header>

<main>
<div class="container-detalle">
    <div class="izquierda">
        <div class="galeria-contenedor">
            <div class="galeria-miniaturas">
                <?php foreach ($lista_imagenes as $index => $url_imagen): ?>
                    <img 
                        src="<?php echo htmlspecialchars($url_imagen); ?>" 
                        alt="Miniatura repuesto" 
                        class="miniatura <?php echo ($index === 0) ? 'activa' : ''; ?>"
                        onclick="cambiarImagenPrincipal(this)"
                        onmouseover="cambiarImagenPrincipal(this)">
                <?php endforeach; ?>
            </div>

            <div class="galeria-principal" onmousemove="aplicarZoom(event)" onmouseleave="quitarZoom()">
                <img 
                    id="imagen-grande" 
                    src="<?php echo htmlspecialchars($lista_imagenes[0] ?? ''); ?>" 
                    alt="<?php echo $repuesto ? htmlspecialchars($repuesto->GetNombre()) : ''; ?>" 
                    class="producto-imagen"
                >
            </div>
        </div>
    </div>
    
    <div class="producto-info-compra">
        <h1><?php echo $repuesto ? htmlspecialchars($repuesto->GetNombre()) : ''; ?></h1>
        <hr>
        <h2>Sobre este Repuesto</h2>

        <?php if (!empty($lista_especificaciones)): ?>
        <table class="datos-especificos">
            <?php foreach ($lista_especificaciones as $especificacion): ?>
                <tr class="datos-tabla">
                    <td class="etiqueta"><?php echo htmlspecialchars($especificacion['nombre_caracteristica']); ?></td>
                    <td class="valor"><?php echo htmlspecialchars($especificacion['valor']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php endif; ?>

        <div class="contenedor-especificaciones">
            <p><?php echo $repuesto ? $repuesto->GetDescripcion() : ''; ?></p>
            <hr>  
        </div>
         
        <div class="info-superficial">
            <div class="dato-superficial">
                <p>REFERENCIA</p>
                <h4><?php echo $repuesto ? htmlspecialchars($repuesto->GetReferencia()) : '-'; ?></h4>
            </div>
            <div class="dato-superficial">
                <p>MARCA VEHÍCULO</p>    
                <h4><?php echo $repuesto ? htmlspecialchars($repuesto->GetMarca_Vehiculo()) : '-'; ?></h4>
            </div>
            <div class="dato-superficial">
                <p>MARCA REPUESTO</p>    
                <h4><?php echo $repuesto ? htmlspecialchars($repuesto->GetMarca_Producto()) : '-'; ?></h4>
            </div>
        </div>

        <?php if (!empty($variantes)): ?>
            <div class="contenedor-variantes">
                <h3 class="titulo-variantes">Selecciona una opción:</h3>
                <div class="lista-variantes">
                <?php foreach ($variantes as $var): ?>
                    <a href="Producto.php?id=<?php echo $var['id']; ?>" 
                    class="btn-variante <?php echo ($var['id'] == $id_actual) ? 'activa' : ''; ?>">
                        <?php echo htmlspecialchars($var['presentacion']); ?>
                    </a>
                <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <input type="hidden" name="id_producto" value="<?php echo $repuesto ? $repuesto->GetId() : 0; ?>">
            <input type="hidden" name="nombre_producto" value="<?php echo $repuesto ? htmlspecialchars($repuesto->GetNombre()) : ''; ?>">
            
            <button type="submit" class="btn-comprar">
                AGREGAR AL CARRITO
            </button>

            <a href="../catalogo/Catalogo.php" class="btn-regresar-catalogo">
                ← Volver al Catálogo
            </a>
        </form>
    </div>   
</div>
</main>   
<script src="Producto.js"></script>
</body>
</html>