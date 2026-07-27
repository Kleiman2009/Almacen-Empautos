const carrusel = document.getElementById('carrusel');
const tarjetas = document.querySelectorAll('.tarjeta-linea');

// 1. Clonamos el primer y último elemento
const primerClon = tarjetas[0].cloneNode(true);
const ultimoClon = tarjetas[tarjetas.length - 1].cloneNode(true);

// 2. Los añadimos al DOM
carrusel.appendChild(primerClon);
carrusel.insertBefore(ultimoClon, tarjetas[0]);

// Ajustamos la posición inicial para que no se vea el clon
carrusel.scrollLeft = tarjetas[0].offsetWidth;

function scrollCarrusel(direccion) {
    const anchoTarjeta = carrusel.querySelector('.tarjeta-linea').offsetWidth + 20;
    
    // Movimiento normal
    carrusel.scrollBy({
        left: direccion * anchoTarjeta,
        behavior: 'smooth'
    });

    // 3. Comprobación de bzucle (con un pequeño delay para que termine la animación)
    setTimeout(() => {
        const maxScroll = carrusel.scrollWidth - carrusel.clientWidth;
        
        if (carrusel.scrollLeft >= maxScroll - 5) {
            carrusel.scrollTo({ left: anchoTarjeta, behavior: 'auto' });
        } else if (carrusel.scrollLeft <= 5) {
            carrusel.scrollTo({ left: maxScroll - anchoTarjeta, behavior: 'auto' });
        }
    }, 500); // El tiempo debe coincidir con la suavidad del scroll
}