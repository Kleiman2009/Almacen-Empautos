<?php
class Cconexion {
    // Agregamos "static" para poder llamarla con los dos puntos ::
    public static function ConexionBD() {
        
        $host = "localhost";
        $dbname = "repuestos";
        $username = "root";
        $password = "FamiliaMalagonVelez";


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

