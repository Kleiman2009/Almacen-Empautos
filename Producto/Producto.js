function toggleCarrito() {
    const carritoMenu = document.getElementById('menu-carrito');
    
    // Si tu menú de líneas usa .active, usa esto:
    carritoMenu.classList.toggle('active'); 
    renderizarProductos();
}

function enviarWhatsApp() {
    let carrito = JSON.parse(sessionStorage.getItem('carrito')) || [];
    let mensaje = "Hola Repuestos Malagón, quiero pedir:\n\n";
    
    carrito.forEach(item => {
        mensaje += `\n- ${item.nombre} (Cant: ${item.cantidad})\n`;
    });

    const telefono = "573166222504"; // Tu número de WhatsApp del almacén
    const url = `https://wa.me/${telefono}?text=${encodeURIComponent(mensaje)}`;
    
    window.open(url, '_blank');
}



function cambiarImagenPrincipal(elementoMiniatura) {
    const imagenGrande = document.getElementById('imagen-grande');
    
    if (imagenGrande && elementoMiniatura) {
        imagenGrande.src = elementoMiniatura.src;
        
        const miniaturas = document.querySelectorAll('.miniatura');
        miniaturas.forEach(min => min.classList.remove('activa'));
        
        elementoMiniatura.classList.add('activa');
    }
}

function aplicarZoom(evento) {
    const contenedor = evento.currentTarget;
    const imagen = contenedor.querySelector('.producto-imagen');
    
    // Obtenemos las dimensiones y coordenadas del contenedor de la imagen
    const rect = contenedor.getBoundingClientRect();
    
    // Calculamos la posición del mouse en porcentaje dentro de la imagen
    const x = ((evento.clientX - rect.left) / contenedor.offsetWidth) * 100;
    const y = ((evento.clientY - rect.top) / contenedor.offsetHeight) * 100;
    
    // Centramos el punto de origen del zoom exactamente donde está el cursor
    imagen.style.transformOrigin = `${x}% ${y}%`;
    
    // Aplicamos el factor de escala (zoom de 2x)
    imagen.style.transform = "scale(2)";
}

function quitarZoom() {
    const contenedor = document.querySelector('.galeria-principal');
    if (contenedor) {
        const imagen = contenedor.querySelector('.producto-imagen');
        // Regresamos la imagen a su estado y tamaño normal
        imagen.style.transformOrigin = "center center";
        imagen.style.transform = "scale(1)";
    }
}  