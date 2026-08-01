<?php
class Cconexion {
    // Agregamos "static" para poder llamarla con los dos puntos ::
    public static function ConexionBD() {
        
        $host = "sql201.infinityfree.com";
        $dbname = "if0_42532505_almacen";
        $username = "if0_42532505";
        $password = "ZdMTewqn7S3KS6";

        try {
            $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
            // Esto es importante para que las tildes funcionen
            $conn->exec("set names utf8");
            return $conn; 
        } catch (PDOException $exp) {
            echo ("No se logró conectar a la base de datos: $dbname, error: $exp");
            return null;
        }
    }
}
?>

