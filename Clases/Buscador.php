<?php

class Buscador {

    public static function buscarPorNombre($termino, $pdo) {
        $listaProductos = [];

        // CASO 1: Si NO hay término de búsqueda, traemos todos los productos
        if ($termino == NULL || trim($termino) == '') {
            $stmt = $pdo->prepare("SELECT * FROM productos");
            $stmt->execute();
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // CASO 2: Si SÍ hay término de búsqueda, filtramos permitiendo varias palabras
        } else {
           $termino = trim($termino);

if (!empty($termino)) {
    $palabras = array_filter(explode(' ', $termino));
    $condiciones = [];
    $parametros = [];

    foreach (array_values($palabras) as $index => $palabra) {
        $paramName = ":termino" . $index;
        
        // Incluye sub_categoria, codigo y campos de la tabla producto_caracteristicas
        $condiciones[] = "(
            p.nombre LIKE $paramName OR 
            p.descripcion LIKE $paramName OR 
            p.marca_producto LIKE $paramName OR 
            p.marca_vehiculo LIKE $paramName OR 
            p.presentacion LIKE $paramName OR 
            p.referencia LIKE $paramName OR 
            p.categoria LIKE $paramName OR 
            p.sub_categoria LIKE $paramName OR
            p.codigo LIKE $paramName OR
            pc.caracteristica LIKE $paramName OR
            pc.valor LIKE $paramName
        )";
        
        $parametros[$paramName] = '%' . $palabra . '%';
    }

    if (!empty($condiciones)) {
        $sql = "SELECT DISTINCT p.* 
                FROM productos p
                LEFT JOIN producto_caracteristicas pc ON p.id = pc.producto_id
                WHERE " . implode(" AND ", $condiciones);

        $stmt = $pdo->prepare($sql);
        $stmt->execute($parametros);
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
        }

        // 2. Procesamos los resultados pasando los 11 argumentos (incluyendo $grupo)
        if (!empty($resultados)) {
            foreach ($resultados as $datos) {
                $listaProductos[] = new producto(
                    $datos['id'] ?? null,
                    $datos['grupo'] ?? null,
                    $datos['nombre'] ?? '',
                    $datos['descripcion'] ?? '',
                    $datos['marca_producto'] ?? '',
                    $datos['marca_vehiculo'] ?? '',
                    $datos['presentacion'] ?? '',
                    $datos['imagen_url'] ?? '',
                    $datos['referencia'] ?? '',
                    $datos['categoria'] ?? '',
                    $datos['sub_categoria'] ?? ''
                );
            }
        }

        return $listaProductos;
    }
}