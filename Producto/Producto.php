<?php
session_start(); 
include_once __DIR__ . '/../Clases/Carrito.php';
include_once __DIR__ . '/../Clases/conexion.php';
include_once __DIR__ . '/../Clases/Producto.php';
include_once __DIR__ . '/../Clases/Buscador.php'; 

$repuesto = null;



$id_a_buscar = isset($_GET['id']) ? intval($_GET['id']) : 0;// Si no viene un ID válido, detenemos el proceso o redirigimos al catálogo
if (!$id_a_buscar) {
    die("Error: No se especificó un ID de producto válido.");
}

// 3. Conectamos a la base de datos
$pdo = Cconexion::ConexionBD(); 

if ($pdo !== null) {
    // 4. Buscamos el producto con el ID dinámico que llegó de la URL
    $repuesto = Producto::buscarPorId($id_a_buscar, $pdo);

}

// Procesar la eliminación de un producto individual del carrito
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'quitar_item') {
    $id_a_quitar = intval($_POST['id_producto_quitar']);
    
    $miCarrito = new Carrito();
    $miCarrito->quitar($id_a_quitar);
    
    // Redirigimos de forma limpia a la misma página actual para actualizar la vista y el conteo
    $pagina_actual = basename($_SERVER['PHP_SELF']);
    if ($pagina_actual === 'Producto.php' && isset($_GET['id'])) {
        header("Location: Producto.php?id=" . intval($_GET['id']));
    } else {
        header("Location: Catalogo.php");
    }
    exit();
}
$id_actual = isset($_GET['id']) ? intval($_GET['id']) : 0;

// 1. Usamos 'caracteristica AS nombre_caracteristica' para que sea compatible con tu HTML actual
$query_specs = "SELECT caracteristica AS nombre_caracteristica, valor 
                FROM producto_caracteristicas 
                WHERE producto_id = :id";

$stmt_specs = $pdo->prepare($query_specs);
$stmt_specs->execute(['id' => $id_actual]);

// 2. Guardamos los resultados
$lista_especificaciones = $stmt_specs->fetchAll(PDO::FETCH_ASSOC);

// Obtenemos las imágenes de la tabla 'imagenes' asociadas a este producto
$lista_imagenes = ($pdo !== null && $id_a_buscar > 0) ? Producto::obtenerImagenesPorId($id_a_buscar, $pdo) : [];

// Si por alguna razón la tabla no tiene registros para este producto, usamos la imagen principal clásica
if (empty($lista_imagenes) && $repuesto) {
    $lista_imagenes[] = $repuesto->Getimagen_Url();
}

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?php echo $repuesto->GetNombre(); ?> - Repuestos Malagón</title>
    <link rel="stylesheet" href="Producto.css">
</head>
<body>
<?php

$pdo = Cconexion::ConexionBD();
// 3. PROCESAMOS EL CARRITO

$miCarrito = new Carrito();

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_producto'])) {
            $id_prod = intval($_POST['id_producto']);
            $nombre_prod = htmlspecialchars($_POST['nombre_producto']);
            
            // Agregamos el repuesto al carrito en la sesión
            $miCarrito->agregar($id_prod, $nombre_prod);
            
        // ✨ SOLUCIÓN AL HISTORIAL: Reemplazamos la entrada actual para poder volver atrás con un solo clic
        echo "<script>window.location.replace('Producto.php?id=" . $id_prod . "');</script>";
        exit();
    }

    $totalItems = Carrito::obtenerTotalGlobal();
    $termino = htmlspecialchars($_GET["q"] ?? "");
    $listaProductos = Buscador::buscarPorNombre($termino, $pdo);
    $productosEnCarrito = $miCarrito->obtenerProductos();

?>



<header> 
  
    <a href="/inicio/index.php" class="cajalogo">
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
    
    <div  class="menu-body">
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
    // Formateamos los productos de la sesión a una cadena JSON limpia y segura para HTML
    $jsonProductos = !empty($productosEnCarrito) ? htmlspecialchars(json_encode($productosEnCarrito), ENT_QUOTES, 'UTF-8') : '[]';
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
        
         <!-- Columna de miniaturas con scroll (ideal para 10 a 20 fotos) -->
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

            <!-- Imagen principal grande -->
            <!-- Imagen Principal Grande con Zoom -->
            <div class="galeria-principal" onmousemove="aplicarZoom(event)" onmouseleave="quitarZoom()">
                <img 
                    id="imagen-grande" 
                    src="<?php echo htmlspecialchars($lista_imagenes[0] ?? ''); ?>" 
                    alt="<?php echo htmlspecialchars($repuesto->GetNombre()); ?>" 
                    class="producto-imagen"
                >
            </div>

        </div>
    </div>
 <hr>

 <!--derecha-->

<div class="producto-info-compra">
           
        <h1><?php echo $repuesto->GetNombre(); ?></h1>
           
    <hr>
             <h2>Sobre este Repuesto</h2>
             <br>
       
      <table class="datos-especificos">
                 <?php foreach ($lista_especificaciones as $especificacion): ?>
        <tr class="datos-tabla">
             <td class="etiqueta"><?php echo $especificacion['nombre_caracteristica']; ?></td>
             <td class="valor"><?php echo $especificacion['valor']; ?></td>
         </tr>
                 <?php endforeach; ?>
    </table>


    <div class="contenedor-especificaciones">

        <p><?php echo $repuesto->GetDescripcion()?></p>
  <hr>  
    </div>
          
        <table class="datos-especificos">
   
    <div class="info-superficial">
                    <div class="dato-superficial">
                        <p>REFERENCIA</p>
                        <h4><?php echo $repuesto->GetReferencia()?></h4>
                    </div>
                    <div class="dato-superficial">
                        <p>MARCA COMPATIBLE</p>    
                        <h4><?php echo $repuesto->GetMarca_Vehiculo()?></h4>
                    </div>
                    <div class="dato-superficial">
                        <p>MARCA REPUESTO</p>    
                        <h4><?php echo $repuesto->GetMarca_Producto()?></h4>
                    </div>

    </div>

    
<?php if (!empty($variaciones)): ?>
    <div class="variaciones-container">
       
            <h4>Seleccione presentación/lado:</h4>
       
        <div class="opciones-grid">
            <!-- La opción actual marcada como activa -->
            <span class="opcion activa"><?php echo $repuesto->GetPresentacion(); ?></span>
            
            <!-- Las otras opciones disponibles -->
            <?php foreach ($variaciones as $v): ?>
                <a href="producto_detalle.php?id=<?php echo $v['id']; ?>" class="opcion">
                    <?php echo $v['presentacion']; ?>
                </a>
            <?php endforeach; ?>
        </div>
        
    </div>
<?php endif; ?>

       <form method="POST" action="">
    <input type="hidden" name="id_producto" value="<?php echo $repuesto->GetId(); ?>">
    <input type="hidden" name="nombre_producto" value="<?php echo htmlspecialchars($repuesto->GetNombre()); ?>">
    
    <button type="submit" class="btn-comprar">
        <p>AGREGAR AL CARRITO</p>
    </button>

    <a href="../catalogo/Catalogo.php" class="btn-regresar-catalogo">
    ← Volver al Catálogo
    </a>

</form>

</div>  

<!-- Este bloque recorre solo lo que existe para ese ID -->

    
    
</div>
</main>
    
<script src="Producto.js"></script> </body>


</html>