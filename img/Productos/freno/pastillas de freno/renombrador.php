<?php
set_time_limit(0);
ini_set('memory_limit', '512M');

$directorioRaiz = __DIR__;

echo "=== INICIANDO RENOMBRADO SECUENCIAL (img_1, img_2...) ===\n";
echo "Escaneando: $directorioRaiz\n\n";

$carpetasIgnoradas = ['aceites', 'amortiguadores', 'chevrolet', 'chino', 'ford', 'kia ! hyundai', 'mazda', 'mitsubishi', 'nissan', 'renault', 'spark', 'nueva carpeta'];

$directorio = new RecursiveDirectoryIterator($directorioRaiz, RecursiveDirectoryIterator::SKIP_DOTS);
$iterador = new RecursiveIteratorIterator($directorio, RecursiveIteratorIterator::SELF_FIRST);

$contadorArchivosTotal = 0;
$controlCarpetas = []; // Para llevar la cuenta por cada carpeta individual

foreach ($iterador as $item) {
    if ($item->isFile()) {
        $rutaCompleta = $item->getRealPath();
        $nombreArchivo = $item->getFilename();
        $extension = strtolower($item->getExtension());
        
        // Ignorar archivos de sistema, descripciones o el propio script
        if (in_array($extension, ['php', 'ini', 'txt'])) {
            continue;
        }

        $rutaCarpetaPadre = dirname($rutaCompleta);
        $nombreCarpetaPadre = basename($rutaCarpetaPadre);
        $nombreCarpetaMin = strtolower($nombreCarpetaPadre);

        // Ignorar las carpetas generales de categorías o marcas
        if (in_array($nombreCarpetaMin, $carpetasIgnoradas)) {
            continue;
        }

        // Si es la primera vez que entramos a esta carpeta de producto, empezamos el conteo en 1
        if (!isset($controlCarpetas[$rutaCarpetaPadre])) {
            $controlCarpetas[$rutaCarpetaPadre] = 1;
        }

        // Mantener el sufijo si la imagen no tiene fondo (opcional, ayuda en la web)
        $esRemoveBg = "" ;

        // Construir el nombre limpio: img_1, img_2, etc.
        $numeroImagen = $controlCarpetas[$rutaCarpetaPadre];
        $nuevoNombreArchivo = "img_" . $numeroImagen . $esRemoveBg . '.' . $extension;
        $nuevaRutaCompleta = $rutaCarpetaPadre . DIRECTORY_SEPARATOR . $nuevoNombreArchivo;

        // Si por alguna razón el archivo ya se llama así, pasamos al siguiente número
        while (file_exists($nuevaRutaCompleta) && $rutaCompleta !== $nuevaRutaCompleta) {
            $numeroImagen++;
            $nuevoNombreArchivo = "img_" . $numeroImagen . $esRemoveBg . '.' . $extension;
            $nuevaRutaCompleta = $rutaCarpetaPadre . DIRECTORY_SEPARATOR . $nuevoNombreArchivo;
        }

        // Actualizar el contador para el próximo archivo de ESTA carpeta
        $controlCarpetas[$rutaCarpetaPadre] = $numeroImagen + 1;

        // Si ya coincide el nombre actual con el nuevo, saltar para no duplicar trabajo
        if ($rutaCompleta === $nuevaRutaCompleta) {
            continue;
        }

        // Ejecutar el cambio de nombre
        if (rename($rutaCompleta, $nuevaRutaCompleta)) {
            echo "[OK] Carpeta: .../$nombreCarpetaPadre -> Creando: $nuevoNombreArchivo\n";
            $contadorArchivosTotal++;
        }
    }
}

echo "\n=========================================\n";
echo "¡PROCESO TERMINADO!\n";
echo "Se organizaron un total de $contadorArchivosTotal imágenes como img_#.\n";
