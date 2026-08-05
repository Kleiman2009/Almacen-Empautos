<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nosotros - Repuestos Malagón</title>
    <link rel="stylesheet" href="nosotros.css">
    <link rel="stylesheet" href="/inicio/footer.css">
</head> 
<body>

    <!-- Header -->
 <header>
    <!-- Logo -->
    <a href="/index.php" class="cajalogo">
        <img class="logo" src="/img/Multimedia/logo.png" alt="logo">
    </a>         

    <!-- Botón de Hamburguesa -->
    <button class="btn-hamburguesa" onclick="toggleMenuNavegacion()">
        &#9776;
    </button>

    <!-- Menú Lateral / Enlaces -->
    <nav class="menu" id="menuNavegacion">
        <!-- Botón para cerrar el menú dentro del panel -->
        <div class="menu-header-movil" style="display: flex; justify-content: space-between; align-items: center; width: 100%; padding: 15px 20px; border-bottom: 1px solid #1a2a47;">
            <span style="color: white; font-weight: bold;">Menú</span>
            <button class="btn-cerrar-menu" onclick="toggleMenuNavegacion()" style="background: none; border: none; color: white; font-size: 28px; cursor: pointer;">&times;</button>
        </div>

        <a href="/index.php" class="catalogo">INICIO</a>
        <a href="/catalogo/Catalogo.php" class="comprar">CATÁLOGO</a>
        <a href="/nosotros/nosotros.php" class="nosotros">NOSOTROS</a>
    </nav>
</header>

    <!-- Main Content -->
    <main>
        <!-- Banner Principal -->
        <div class="banner-container">
            <img class="banner" src="/img/Multimedia/flayer.png" alt="Banner Repuestos Malagón">
        </div>

        <!-- Propósito (Misión y Visión) -->
        <section class="proposito">
            <h1 class="nuestro">NUESTRO PROPÓSITO</h1>
            <div class="vision">
                
                <div class="mision">
                    <div class="titulo-mision">
                        <div class="figurita">
                            <img class="dibujo" src="/img/Multimedia/mision.png" alt="Icono Misión">
                        </div>
                        <h2>Nuestra Misión</h2>
                    </div>
                    <p>En Repuestos Malagón nos dedicamos a ofrecer repuestos automotrices de la más alta calidad para vehículos livianos y pesados, brindando una atención cercana, asesoría experta y precios justos. Trabajamos cada día para que nuestros clientes encuentren la pieza correcta en el momento correcto, garantizando seguridad y rendimiento en cada viaje.</p>
                </div>

                <div class="mision">
                    <div class="titulo-mision">
                        <div class="figurita">
                            <img class="dibujo" src="/img/Multimedia/vision.png" alt="Icono Visión">
                        </div>
                        <h2>Nuestra Visión</h2>
                    </div>        
                    <p>Para el año 2030, ser reconocidos como el almacén de repuestos automotrices líder en el Valle del Cauca, destacándonos por la innovación en el servicio, la amplia variedad de productos y la confianza que generamos en nuestros clientes. Aspiramos a expandir nuestra presencia y consolidarnos como referente regional en el sector automotriz.</p>
                </div>

            </div>
        </section>
      
        <!-- Historia -->
        <section class="historia">
            <div class="nuestra-historia">
                <h2>NUESTRA <span>HISTORIA</span></h2>
                <div class="linea-decorativa"></div>
                <h3>Años de experiencia respaldándonos</h3>
            </div>
            
            <div class="text">
                <p>Repuestos Malagón nació en Guadalajara de Buga, Valle del Cauca, gracias al esfuerzo de una familia apasionada por el mundo automotriz. Lo que comenzó como un pequeño local de barrio dedicado a vender repuestos básicos, poco a poco se transformó en un punto de referencia para conductores, mecánicos y transportadores de la región.</p>
                <p>A lo largo de los años hemos crecido junto a nuestros clientes, ampliando nuestro inventario con líneas completas de distribución, lubricación, refrigeración, suspensión, frenos, embrague, transmisión, admisión, eléctrico, lujos, balineras y grasas para las marcas más reconocidas del mercado: Chevrolet, Kia, Toyota, Mazda, Renault, Hyundai y Nissan.</p> 
                <p>Hoy, bajo el sello de Almacén Empautos, seguimos fieles a los valores que nos vieron crecer: honestidad, conocimiento técnico y un servicio cercano que trata a cada cliente como parte de la familia. Cada repuesto que entregamos lleva consigo años de aprendizaje, esfuerzo y compromiso con la calidad.</p>
                
                <div class="datos">
                    <div class="daticos">
                        <span class="numero-grande">50</span>
                        <p>Años de servicio</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Promoción / CTA -->
        <section class="promocion">
            <div class="promocion-contenido">
                <h1>¿Necesitas un repuesto específico?</h1>
                <p>Visita nuestro catálogo o contáctanos directamente, te ayudamos a encontrar lo que buscas.</p>
                
                <div class="promocion-inferior">
                    <a href="/catalogo/Catalogo.php" class="ver-catalogo">
                        <span>VER CATÁLOGO</span> &gt;
                    </a>
                    
                    <a href="https://wa.me/3166222504" target="_blank" class="escribenos" rel="noopener noreferrer">
                        <img class="burbuja-de-chat" src="./img/burbuja-de-chat.png" alt="WhatsApp">
                        <span>ESCRÍBENOS</span>
                    </a>
                </div>      
            </div> 
        </section>
    </main>

    <!-- Footer -->
    <?php
    include __DIR__ . '/../inicio/footer.php';
    ?>

    <script src="script.js"></script> 
</body>
</html>