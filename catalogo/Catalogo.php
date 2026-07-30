    <?php
session_start(); 
include_once __DIR__ . '/../Clases/Carrito.php';
include_once __DIR__ . '/../Clases/conexion.php';
include_once __DIR__ . '/../Clases/Producto.php';
include_once __DIR__ . '/../Clases/Buscador.php'; 

$pdo = Cconexion::ConexionBD();
$miCarrito = new Carrito();

// 3. PROCESAMOS EL CARRITO (POST para agregar)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
    $id_prod = intval($_POST['id_producto']);
    $nombre_prod = htmlspecialchars($_POST['nombre_producto']);
    
    // Agregamos el repuesto al carrito en la sesión
    $miCarrito->agregar($id_prod, $nombre_prod);
    
    echo "<script>window.location.replace('Producto.php?id=" . $id_prod . "');</script>";
    exit();
}

// Procesar la eliminación de un producto individual del carrito
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

$totalItems = Carrito::obtenerTotalGlobal();
// Capturamos el término de búsqueda de forma segura
$termino = htmlspecialchars($_GET["q"] ?? "");

// Ejecutamos la búsqueda flexible con el método optimizado
$listaProductos = Buscador::buscarPorNombre($termino, $pdo);
$productosEnCarrito = $miCarrito->obtenerProductos();
?>
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
<header> 
<a href="/index.php" class="cajalogo">
    <img class="logo" src="/img/Multimedia/logo.png" alt="logo">
    
</a>                 

<!-- Formulario del buscador con botón oculto para asegurar el envío al presionar Enter -->
<form class="buscador" action="Catalogo.php" method="get">
    <input class="buscar" name="q" id="inputBuscador" type="text" placeholder="Buscar repuesto..." value="<?php echo $termino; ?>">
    <button type="submit" style="display: none;"></button>
</form>

<a id="carrito" class="carrito" href="javascript:void(0)" onclick="toggleCarrito()">
    <img class="carritoimg" src="/img/Multimedia/carrito.svg" alt="carrito">
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
                            <strong style="font-size: 0.95rem;"><?php echo htmlspecialchars($item['nombre']); ?></strong><br>
                            <span style="color: #26eedb; font-size: 0.85rem;">Cantidad: <?php echo $item['cantidad']; ?></span>
                        </div>
                        
                        <form method="POST" action="" style="margin: 0;">
                            <input type="hidden" name="action" value="quitar_item">
                            <input type="hidden" name="id_producto_quitar" value="<?php echo $id; ?>">
                            <button type="submit" class="btn-eliminar-item" title="Quitar del carrito">
                                &times;
                            </button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="menu-footer">
        <?php
            $jsonProds = !empty($productosEnCarrito) ? json_encode($productosEnCarrito) : '[]';
            $base64Productos = base64_encode($jsonProds);
        ?>
        <button 
            onclick="enviarWhatsApp(this)" 
            class="btn-finalizar" 
            id="finalizar-compra" 
            data-productos="<?php echo $base64Productos; ?>">
            Finalizar Compra
        </button>
    </div>
</div>
</header>

<nav class="barra-productos">
    <button class="flecha flecha-izq" onclick="scrollCarrusel(-1)">&#10094;</button>
    <button class="flecha flecha-der" onclick="scrollCarrusel(1)">&#10095;</button>
    <div id="contenedor-categorias" class="contenedor-categorias">
        <button class="btn-cat" onclick="filtrarSub('distribucion')">DISTRIBUCIÓN</button>
        <button class="btn-cat" onclick="filtrarSub('lubricacion')">LUBRICACIÓN</button>
        <button class="btn-cat" onclick="filtrarSub('refrigeracion')">REFRIGERACIÓN</button>
        <button class="btn-cat" onclick="filtrarSub('suspencion')">SUSPENCIÓN</button>
        <button class="btn-cat" onclick="filtrarSub('frenos')">FRENOS</button>
        <button class="btn-cat" onclick="filtrarSub('embrague')">EMBRAGUE</button>
        <button class="btn-cat" onclick="filtrarSub('transmision')">TRANSMISIÓN</button>
        <button class="btn-cat" onclick="filtrarSub('admision')">ADMISIÓN</button>
        <button class="btn-cat" onclick="filtrarSub('electrico')">ELECTRICO</button>
        <button class="btn-cat" onclick="filtrarSub('lujos')">LUJOS</button>
        <button class="btn-cat" onclick="filtrarSub('balineras')">BALINERAS</button>
        <button class="btn-cat" onclick="filtrarSub('grasas')">GRASAS</button>
        <button class="btn-cat" onclick="filtrarSub('reteneria')">RETENERIA</button>
    </div>
</nav>

<main>
<section id="panel-subcategorias" class="panel-sub"></section>

<section id="catalogo-productos" class="contenedor-productos">
    <?php if (empty($listaProductos)): ?>
        <p style="text-align:center; color:#fff; width:100%; grid-column: 1 / -1; padding: 40px;">No se encontraron repuestos con ese criterio de búsqueda.</p>
    <?php else: ?>
        <?php foreach ($listaProductos as $prod) { ?>
        <div class="tarjeta-repuesto">
            <a href="/./Producto/Producto.php?id=<?php echo $prod->GetId(); ?>"> 
                <img src="<?php echo $prod->GetImagen_Url(); ?>" alt="<?php echo $prod->GetNombre(); ?>">
            </a>
            <div class="info-repuesto">
                <h3 class="producto-titulo"><?php echo $prod->GetNombre(); ?></h3>
                <p class="marca">Marca: <?php echo $prod->GetMarca_Producto(); ?></p>   
                <p class="tipo">Tipo: <?php echo $prod->GetCategoria(); ?></p>   
                <div class="contenedor-btn">
                    <div class="card-acciones">
                        <a href="../Producto/Producto.php?id=<?php echo $prod->GetId(); ?>" class="btn-ver-mas">
                            VER DETALLES
                        </a>
                    </div>
                </div>
            </div>       
        </div> 
      <?php } ?>
    <?php endif; ?>
</section>
</main>

<?php include __DIR__ . '/../inicio/footer.php'; ?>
<script src="Catalogo.js"></script> 
</body>
</html>