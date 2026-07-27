
function toggleCarrito() {
    const carritoMenu = document.getElementById('menu-carrito');
    
    // Si tu menú de líneas usa .active, usa esto:
    carritoMenu.classList.toggle('active'); 
    renderizarProductos();
}

let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];



function actualizarTodo() {

    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];

}



const subdatos = {
    
    
    'distribucion': [
        { nombre: 'Correas', img: '/img/Productos/Distribucion/Correas/Portada.png'},
        { nombre: 'Tensores y Poleas', img: '/img/Productos/Distribucion/Kit de Distribucion/Portada.png' },
        { nombre: 'Kit de Distribucion', img:'/img/Productos/Distribucion/Tensores y poleas/Portada.png' },
    ],
    'lubricacion': [
        { nombre: 'Aceites', img: '/img/Productos/Lubricacion/aceites/Portada.png'},
        { nombre: 'Filtros', img: '/img/Productos/Lubricacion/Filtros/Portada.png' },
        { nombre: 'Componentes', img:'/img/Productos/Lubricacion/Componentes/Portada.png' },
        { nombre: 'Aditivos', img: '/img/Productos/Lubricacion/Aditivos/Portada.png' }
    ],
     'refrigeracion':[
        {nombre: 'radiadores',  img: '/img/Productos/Refrigeracion/Radiadores/Portada.png'},
        {nombre: 'termostato' ,  img: '/img/Productos/Refrigeracion/Termostato/Portada.png '},
        {nombre: 'refrigerante' ,  img: '/img/Productos/Refrigeracion/refrigerantes/Portada.png'},
        {nombre: 'mangueras' ,  img: '/img/Productos/Refrigeracion/Mangueras/Portada.png'},
        {nombre: 'moto ventildor',  img: '/img/Productos/Refrigeracion/Moto_Ventilador/Portada.png'},
        {nombre: 'ventilador',  img: '/img/Productos/Refrigeracion/Ventilador/Portada.png'},
        {nombre: 'Fan Clutch',  img: '/img/Productos/Refrigeracion/Fan_clutch/Portada.png'},
    ],
    'suspencion': [
        { nombre: 'Rótulas', img: '/img/Productos/suspencion/rotulas/Portada.png'},
        { nombre: 'Amortiguadores', img: '/img/Productos/suspencion/amortiguadores/Portada.png' },
        { nombre: 'Terminales', img:'/img/Productos/suspencion/terminales/Portada.png' },
        { nombre: 'Tijeras', img: '/img/Productos/suspencion/Tijeras de Suspencion/Portada.png' },
        { nombre: 'Brazo Axial', img: '/img/Productos/suspencion/Brazo Axial/Portada.png' },
        { nombre: 'Barra Estabilizadora', img: '/img/Productos/suspencion/Barra Estabilizadora/Portada.png' }
    ],
    'frenos': [
        { nombre: 'Pastillas de Freno', img: '/img/Productos/freno/Pastillas de freno/Portada.png' },
        { nombre: 'Discos', img: '/img/Productos/freno/Discos de Freno/Portada.png' },
        { nombre: 'piston caliper', img: '/img/Productos/freno/Piston de Caliper/Portada.png'},
        { nombre: 'puntilla caliper', img: '/img/Productos/freno/Puntillas de Caliper/Portada.png'},
        { nombre: 'bandas de freno', img: '/img/Productos/freno/Bandas de Freno/Portada.png'},
        { nombre: 'liquido de freno', img: '/img/Productos/freno/liquido de Freno/Portada.png'},
        { nombre: 'servo motor', img: '/img/Productos/freno/Servo Motor/Portada.png'},
        { nombre: 'graduacion de freno', img: '/img/Productos/freno/Graduacion de Freno/Portada.png'},
        { nombre: 'Bomba de Freno', img: '/img/Productos/freno/Bomba de Freno/Portada.png'},
        { nombre: 'Cilindro de Freno', img: '/img/Productos/freno/Cilindro de Freno/Portada.png'}         
    ],
    'embrague': [
        {nombre: 'kit de embrague', img: '/img/Productos/Embrague/Kit de Embrague/Portada.png'},
        {nombre: 'disco de embrague', img: '/img/Productos/Embrague/Disco de Embrague/Portada.png'},
        {nombre: 'prensa de embrague', img: '/img/Productos/Embrague/Prensa de Embrague/Portada.png'},
        {nombre: 'balinera de embrague', img: '/img/Productos/Embrague/Balinera de Embrague/Portada.png'},
        {nombre: 'Bomba Auxiliar de Embrague', img: '/img/Productos/Embrague/Bomba Auxiliar de Embrague/Portada.png'},
        {nombre: 'Bomba Principal de Embrague', img: '/img/Productos/Embrague/Bomba Principal de Embrague/Portada.png'},
        {nombre: 'Orquilla de Embrague', img: '/img/Productos/Embrague/Orquilla de Embrague/Portada.png'},

    ],
    'transmision': [
        {nombre: 'Juntas Homocineticas', img: '/img/Productos/Transmicion/Juntas Homocinetica/Portada.png'},
        {nombre: 'Cardan',  img: '/img/Productos/Transmicion/Cardan/Portada.png'},
        {nombre: 'Soporte Caja',  img: '/img/Productos/Transmicion/Soporte Caja/Portada.png'},
        {nombre: 'Bujes Palanca de Cambios',  img: '/img/Productos/Transmicion/Buje Palanca de Cambios/Portada.png'},
       ],
    'admision':[
        {nombre: 'Carburador', img: '/img/Productos/Admision/Carburador/Portada.png'},
        {nombre: 'Gestion Aire',  img: '/img/Productos/Admision/Gestion Aire/Portada.png'},
        {nombre: 'Bombas de Gasolina',  img: '/img/Productos/Admision/Bombas de Gasolina/Portada.png'},
        {nombre: 'Inyectores',  img: '/img/Productos/Admision/Inyectores/Portada.png'},
        {nombre: 'Filtro de Gasolina',  img: '/img/Productos/Admision/Filtro de Gasolina/Portada.png'},
    ],
    'electrico':[
        {nombre: 'Arranque', img:'/img/Productos/electrico/Arranque/Portada.png' },
        {nombre: 'Encendido', img:'/img/Productos/electrico/Encendido/Portada.png' },
        {nombre: 'Iluminación', img:'/img/Productos/electrico/Iluminacion/Portada.png'},
        {nombre: 'Sensores', img:'/img/Productos/electrico/Sensores/Portada.png'},
        {nombre: 'Control Y Proteccion', img:'/img/Productos/electrico/Control Y Proteccion/Portada.png'},        
    ],
    'lujos':[
        {nombre: 'Bompers', img:'/img/Productos/Confort/Bompers/Portada.png'},
        {nombre: 'Farolas', img:'/img/Productos/Confort/Farolas/Portada.png'},
        {nombre: 'Tapetes', img:'/img/Productos/Confort/Tapetes/Portada.png'},
        {nombre: 'Forros volante', img:'/img/Productos/Confort/Forros Volante/Portada.png'},
        {nombre: 'Pomos Palanca', img:'/img/Productos/Confort/Pomos Palanca/Portada.png'},
        {nombre: 'Filtro Aire Acondicionado', img:'/img/Productos/Confort/Filtro Aire Acondicionado/Portada.png'},
    ],
    'balineras':[
        {nombre: 'Balinera'},
        {nombre: 'Rodamiento'},
       
    ],
     'grasas':[
        {nombre: 'Multiuso'},
        {nombre: 'Especializadas'},
        
    ],
    'reteneria':[
        {nombre: 'Multiuso'},
        {nombre: 'Especializadas'},
        
    ],
};

// SUSTITUIR DESDE LA LÍNEA 225 EN ADELANTE:

function filtrarSub(categoria) {
    const contenedor = document.getElementById('panel-subcategorias');
    const catalogo = document.getElementById('catalogo-productos');

    if (!catalogo) {
        console.error("¡Oye! No encontré el elemento con ID 'catalogo-productos'");
        return;
    }

    // 1. ESCONDER EL CATÁLOGO ACTUAL PARA DAR PASO A LAS SUBCATEGORÍAS
    catalogo.style.visibility = "hidden";
    catalogo.style.height = "0";
    catalogo.style.overflow = "hidden";

    // 2. LIMPIAR EL PANEL Y BUSCAR LOS DATOS
    contenedor.innerHTML = "";
    const lista = subdatos[categoria];

    if (lista) {
        lista.forEach(sub => {
            // Creamos el "botón-tarjeta"
            const cardSub = document.createElement('div');
            cardSub.className = 'card-subcategoria';

            cardSub.innerHTML = `
                <img src="${sub.img}" class="imagen-sub-categoria" alt="hola">
                <span class="nombre-sub-categoria">${sub.nombre}</span>
            `;

            // 3. ACCIÓN AL CLICKEAR LA SUBCATEGORÍA
            cardSub.onclick = () => {
                cargarProductosPorSubcategoria(sub.nombre);
            };

            contenedor.appendChild(cardSub);
        });
    }

    contenedor.style.display = "flex";
}

// 4. NUEVA FUNCIÓN PARA TRAER PRODUCTOS DE LA DB SIN RECARGAR
function cargarProductosPorSubcategoria(nombreSub) {
    const catalogo = document.getElementById('catalogo-productos');
    const panelSub = document.getElementById('panel-subcategorias');

    // Preparamos el envío (el nombre debe coincidir con el de tu columna en SQL)
    const formData = new FormData();
    formData.append('subcategoria', nombreSub);

    fetch('buscar_productos.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(html => {
        // Ocultamos las subcategorías para mostrar los resultados
        panelSub.style.display = 'none';

        // Volvemos a hacer visible el contenedor de productos y metemos el HTML nuevo
        catalogo.style.visibility = "visible";
        catalogo.style.height = "auto";
        catalogo.style.overflow = "visible";
        catalogo.innerHTML = html; 
    })
    .catch(error => {
        console.error('Error al cargar productos:', error);
        alert("Hubo un error al conectar con la base de datos.");
    });
}

window.onload = function() {
    const urlParams = new URLSearchParams(window.location.search);
    const categoriaDesdeUrl = urlParams.get('cat');

    if (categoriaDesdeUrl) {
        // Ejecuta la lógica de mostrar subcategorías inmediatamente
        filtrarSub(categoriaDesdeUrl);
    }
};


function enviarWhatsApp(boton) {
    // 1. Leemos el string en Base64
    let base64Data = boton.getAttribute('data-productos');
    if (!base64Data) {
        alert("No se encontraron productos en el botón.");
        return;
    }

    let carritoRaw = null;
    try {
        // 2. Decodificamos el JSON
        let jsonTexto = atob(base64Data);
        carritoRaw = JSON.parse(jsonTexto);
    } catch (e) {
        console.error("Error al procesar el carrito:", e);
        alert("Hubo un problema al leer los productos del carrito.");
        return;
    }

    // 3. ¡EL TRUCO CLAVE! Convertimos el objeto asociativo {} a un Array []
    // Esto extrae solo los datos de los productos ignorando las llaves numéricas de los IDs
    let carrito = carritoRaw ? Object.values(carritoRaw) : [];

    console.log("Carrito convertido a Array listo para usarse:", carrito);

    if (carrito.length === 0) {
        alert("El carrito está vacío. Añade algunos repuestos antes de finalizar tu compra.");
        return;
    }

    // 4. Construimos el mensaje para el almacén
    let mensaje = "¡Hola Repuestos Malagón! 👋 Quiero realizar el siguiente pedido:\n\n";
    
    carrito.forEach(item => {
        // Buscamos las propiedades dentro del objeto del producto
        // Ajusta las variables si en tu clase de PHP sus atributos privados se llaman diferente
        let nombre = item.Nombre || item.nombre || item.nombre_producto || "Repuesto";
        let cantidad = item.Cantidad || item.cantidad || item.cant || 1;
        
        mensaje += `• ${nombre} (Cant: ${cantidad})\n`;
    });

    mensaje += "\n¿Me podrían confirmar disponibilidad y precios? ¡Muchas gracias!";

    // 5. Abrimos la API de WhatsApp en una pestaña nueva
    const telefono = "573166222504"; 
    const url = `https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`;
    window.open(url, '_blank');
}

function scrollCarrusel(direccion) {
    // Seleccionamos el contenedor interno de los botones
    const contenedor = document.getElementById('contenedor-categorias');
    
    // Cantidad de píxeles que se desplazará en cada click
    const paso = 200; 
    
    // Multiplicamos el paso por la dirección (-1 para izquierda, 1 para derecha)
    contenedor.scrollLeft += (paso * direccion);
}