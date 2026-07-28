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

// 1. Procesar la eliminación de un ítem del carrito
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

// 2. Procesar la adición de un producto al carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_prod = intval($_POST['id_producto']);
    $nombre_prod = htmlspecialchars($_POST['nombre_producto']);
    
    $miCarrito->agregar($id_prod, $nombre_prod);
    
    echo "<script>window.location.replace('Producto.php?id=" . $id_prod . "');</script>";
    exit();
}

$id_actual = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Obtener especificaciones e imágenes
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
    <title><?php echo $repuesto ? htmlspecialchars($repuesto->GetNombre()) : 'Producto'; ?> - Repuestos Malagón</title>
    <link rel="stylesheet" href="Producto.css">
    <script>
    // Función de WhatsApp sincronizada con el JSON del carrito PHP
    function enviarWhatsApp(boton) {
        let base64Data = boton.getAttribute('data-productos');
        if (!base64Data) {
            alert("No se encontraron productos en el botón.");
            return;
        }

        let carritoRaw = null;
        try {
            let jsonTexto = atob(base64Data);
            carritoRaw = JSON.parse(jsonTexto);
        } catch (e) {
            console.error("Error al procesar el carrito:", e);
            alert("Hubo un problema al leer los productos del carrito.");
            return;
        }

        let carrito = carritoRaw ? Object.values(carritoRaw) : [];

        if (carrito.length === 0) {
            alert("El carrito está vacío. Añade algunos repuestos antes de finalizar tu compra.");
            return;
        }

        let mensaje = "¡Hola Repuestos Malagón! 👋 Quiero realizar el siguiente pedido:\n\n";
        
        carrito.forEach(item => {
            let nombre = item.Nombre || item.nombre || item.nombre_producto || "Repuesto";
            let cantidad = item.Cantidad || item.cantidad || item.cant || 1;
            mensaje += `• ${nombre} (Cant: ${cantidad})\n`;
        });

        mensaje += "\n¿Me podrían confirmar disponibilidad y precios? ¡Muchas gracias!";

        const telefono = "573166222504"; 
        const url = `https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`;
        window.open(url, '_blank');
    }
    </script>
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
            <button class="btn-cerrar" onclick="toggleCarrito()">&times;</button>
            <h2>Mi Carrito</h2>
        </div>
        
        <div class="menu-body">
            <div id="contenido-carrito">
                <?php if (empty($productosEnCarrito)): ?>
                    <p style="text-align:center; padding:20px; color:#fff;">El carrito está vacío.</p>
                <?php else: ?>
                    <?php foreach ($productosEnCarrito as $id => $item): ?>
                        <div class="item-carrito" style="display: flex; justify-content: space-between; align-items: center; padding: 12px; border-bottom: 1px solid #22313a; color:#fff;">
                            <div>
                                <strong style="font-size: 0.95rem;"><?php echo htmlspecialchars($item['nombre'] ?? $item['Nombre'] ?? 'Repuesto'); ?></strong><br>
                                <span style="color: #26eedb; font-size: 0.85rem;">Cantidad: <?php echo $item['cantidad'] ?? $item['Cantidad'] ?? 1; ?></span>
                            </div>
                            
                            <form method="POST" action="" style="margin: 0;">
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
                // Generamos el JSON codificado en base64 para que el script lo lea sin conflictos con comillas HTML
                $jsonProductos = !empty($productosEnCarrito) ? base64_encode(json_encode($productosEnCarrito)) : base64_encode(json_encode([]));
            ?>
            <button 
                onclick="enviarWhatsApp(this)" 
                class="btn-finalizar" 
                id="finalizar-compra" 
                data-productos="<?php echo $jsonProductos; ?>">
                Finalizar Compra
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
    
    <hr>

    <div class="producto-info-compra">
        <h1><?php echo $repuesto ? htmlspecialchars($repuesto->GetNombre()) : ''; ?></h1>
        <hr>
        <h2>Sobre este Repuesto</h2>
        <br>
   
        <table class="datos-especificos">
            <?php foreach ($lista_especificaciones as $especificacion): ?>
                <tr class="datos-tabla">
                    <td class="etiqueta"><?php echo htmlspecialchars($especificacion['nombre_caracteristica']); ?></td>
                    <td class="valor"><?php echo htmlspecialchars($especificacion['valor']); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>

        <div class="contenedor-especificaciones">
            <?php echo $repuesto ? $repuesto->GetDescripcion() : ''; ?>
            <hr>  
        </div>
         
        <div class="info-superficial">
            <div class="dato-superficial">
                <p>REFERENCIA</p>
                <h4><?php echo $repuesto ? htmlspecialchars($repuesto->GetReferencia()) : ''; ?></h4>
            </div>
            <div class="dato-superficial">
                <p>MARCA COMPATIBLE</p>    
                <h4><?php echo $repuesto ? htmlspecialchars($repuesto->GetMarca_Vehiculo()) : ''; ?></h4>
            </div>
            <div class="dato-superficial">
                <p>MARCA REPUESTO</p>    
                <h4><?php echo $repuesto ? htmlspecialchars($repuesto->GetMarca_Producto()) : ''; ?></h4>
            </div>
        </div>

        <form method="POST" action="">
            <input type="hidden" name="id_producto" value="<?php echo $repuesto ? $repuesto->GetId() : 0; ?>">
            <input type="hidden" name="nombre_producto" value="<?php echo $repuesto ? htmlspecialchars($repuesto->GetNombre()) : ''; ?>">
            
            <button type="submit" class="btn-comprar">
                <p>AGREGAR AL CARRITO</p>
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