<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repuestos Malagon</title>
    <link rel="stylesheet" href="/inicio/style.css">
    <link rel="stylesheet" href="/inicio/footer.css">
</head>
<body>
    
<header> 
    <a class="cajalogo" href="#">
        <img class="logo" src="/img/Multimedia/logo.png" alt="logo">
    </a>

    <nav class="menu">
        <a class="catalogo" href="#">INICIO</a>
        <a class="catalogo" href="/catalogo/Catalogo.php">CATALOGO</a>
        <a class="nosotros" href="nosotros/nosotros.php">NOSOTROS</a>
    </nav>
</header>

<main>
    <img class="flayer" src="/img/Multimedia/flayer.png" alt="flayer">

    <div class="titul">
        <h1 class="titulo">NUESTROS PRODUCTOS</h1>
    </div>
    <hr>

    <!-- Carrusel de Categorías -->    
    <div class="carrusel-externo">
        <button class="flecha flecha-izq" onclick="scrollCarrusel(-1)">❮</button>
        <button class="flecha flecha-der" onclick="scrollCarrusel(1)">❯</button>
        
        <div class="fotosuperiores" id="carrusel">
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=distribucion">
                    <img class="foto" src="../img/categorias/distribucion.jpeg" alt="Distribución"> 
                </a>
                <p class="textotarjeta">DISTRIBUCIÓN</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=lubricacion">
                    <img class="foto" src="../img/categorias/Lubricacion.jpeg" alt="Lubricación">
                </a>
                <p class="textotarjeta">LUBRICACIÓN</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=refrigeracion">
                    <img class="foto" src="../img/categorias/refrigeracion.jpg" alt="Refrigeración">
                </a>
                <p class="textotarjeta">REFRIGERACIÓN</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=suspension">
                    <img class="foto" src="../img/categorias/amortiguacion.jpg" alt="Suspensión">
                </a>
                <p class="textotarjeta">SUSPENSIÓN</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=frenos">
                    <img class="foto" src="../img/categorias/frenos.jpg" alt="Frenos">
                </a>
                <p class="textotarjeta">FRENOS</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=embrague">
                    <img class="foto" src="../img/categorias/Embrague.jpeg" alt="Embrague">
                </a>
                <p class="textotarjeta">EMBRAGUE</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=transmision">
                    <img class="foto" src="../img/categorias/transmision (1).jpeg" alt="Transmisión">
                </a>
                <p class="textotarjeta">TRANSMISIÓN</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=admision">
                    <img class="foto" src="../img/categorias/admision.jpeg" alt="Admisión">
                </a>
                <p class="textotarjeta">ADMISIÓN</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=electrico">
                    <img class="foto" src="../img/categorias/lujos.png" alt="Eléctrico">
                </a>
                <p class="textotarjeta">ELECTRICO</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=lujos">
                    <img class="foto" src="../img/categorias/lujos.png" alt="Lujos">
                </a>
                <p class="textotarjeta">LUJOS</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=balineras">
                    <img class="foto" src="../img/categorias/rodamientos.png" alt="Rodamientos">
                </a>
                <p class="textotarjeta">RODAMIENTOS</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=grasas">
                    <img class="foto" src="../img/categorias/lujos.png" alt="Grasas">
                </a>
                <p class="textotarjeta">GRASAS</p>
            </div>
            <div class="tarjeta-linea">
                <a href="/catalogo/Catalogo.php?cat=reteneria">
                    <img class="foto" src="../img/categorias/reteneria.jpg" alt="Retenería">
                </a>
                <p class="textotarjeta">RETENERIA</p>
            </div>
        </div>
    </div>
    <hr>                                                          

    <!-- Secciones Inferiores -->
    <h1 class="titulonosotros">CÓNOCENOS UN POCO</h1>
    <section class="masabajo">
        <a class="contenedor-inferior-imagenes" href="https://google.com" target="_blank" rel="noopener noreferrer">
            <img class="imagenes-nosotros" src="/img/Multimedia/ubicacionv2.jpg" alt="Ubicación">
        </a>
        <a class="contenedor-inferior-imagenes" href="/catalogo/Catalogo.php">
            <img class="imagenes-nosotros" src="/img/Multimedia/catalogov2.png" alt="Catálogo">
        </a>
    </section>
</main>

<?php include('inicio/footer.php'); ?>

<script src="/inicio/script.js"></script> 
</body>
</html>
