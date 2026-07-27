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
            // Separamos lo que escribió el usuario por espacios (ej: "pastilla mazda" => ["pastilla", "mazda"])
            $palabras = explode(' ', trim($termino));    
            $condiciones = [];
            $parametros = [];

            foreach ($palabras as $index => $palabra) {
                if (!empty($palabra)) {
                    $paramName = ":termino" . $index;
                    
                    // Cada palabra buscará en cualquiera de los campos de texto
                    $condiciones[] = "(
                        nombre COLLATE utf8mb4_unicode_ci LIKE $paramName OR 
                        descripcion COLLATE utf8mb4_unicode_ci LIKE $paramName OR 
                        marca_producto COLLATE utf8mb4_unicode_ci LIKE $paramName OR 
                        marca_vehiculo COLLATE utf8mb4_unicode_ci LIKE $paramName OR 
                        presentacion COLLATE utf8mb4_unicode_ci LIKE $paramName OR 
                        referencia COLLATE utf8mb4_unicode_ci LIKE $paramName OR 
                        categoria COLLATE utf8mb4_unicode_ci LIKE $paramName
                    )";
                    
                    $parametros[$paramName] = '%' . $palabra . '%';
                }
            }

            // Construimos la consulta uniendo las palabras con AND
            $sql = "SELECT * FROM productos";
            if (!empty($condiciones)) {
                $sql .= " WHERE " . implode(" AND ", $condiciones);
            }

            $stmt = $pdo->prepare($sql);
            $stmt->execute($parametros);
            $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        // 2. Procesamos los resultados (sirve tanto para el IF como para el ELSE)
        if (!empty($resultados)) {
            foreach ($resultados as $datos) {
                $listaProductos[] = new Producto(
                    $datos['id'],
                    $datos['nombre'],
                    $datos['descripcion'],
                    $datos['marca_producto'],
                    $datos['marca_vehiculo'],
                    $datos['presentacion'],
                    $datos['imagen_url'],
                    $datos['referencia'],
                    $datos['categoria'],
                    $datos['sub_categoria']
                );
            }
        }

        return $listaProductos;
    }
}