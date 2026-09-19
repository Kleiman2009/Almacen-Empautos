function toggleCarrito() {
    const carritoMenu = document.getElementById('menu-carrito');
    if (carritoMenu) {
        carritoMenu.classList.toggle('active'); 
    }
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
    // Zoom activo únicamente en pantallas de escritorio (anchos superiores a 768px)
    if (window.innerWidth < 768) return;

    const contenedor = evento.currentTarget;
    const imagen = contenedor.querySelector('.producto-imagen');
    
    const rect = contenedor.getBoundingClientRect();
    const x = ((evento.clientX - rect.left) / contenedor.offsetWidth) * 100;
    const y = ((evento.clientY - rect.top) / contenedor.offsetHeight) * 100;
    
    imagen.style.transformOrigin = `${x}% ${y}%`;
    imagen.style.transform = "scale(1.8)";
}

function quitarZoom() {
    const contenedor = document.querySelector('.galeria-principal');
    if (contenedor) {
        const imagen = contenedor.querySelector('.producto-imagen');
        imagen.style.transformOrigin = "center center";
        imagen.style.transform = "scale(1)";
    }
}  

function enviarWhatsApp(boton) {
    let base64Data = boton.getAttribute('data-productos');
    if (!base64Data) {
        alert("No se encontraron productos en el carrito.");
        return;
    }

    let carritoRaw = null;
    try {
        let jsonTexto = atob(base64Data);
        carritoRaw = JSON.parse(jsonTexto);
    } catch (e) {
        console.error("Error al procesar el carrito:", e);
        alert("Hubo un problema al leer los productos.");
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