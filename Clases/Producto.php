<?php 
    class producto { 

        protected $id;
        protected $grupo;
        protected $Nombre;
        protected $Descripcion;
        protected $Marca_Producto;
        protected $Marca_Vehiculo;
        protected $Presentacion;
        protected $imagen_url;
        protected $referencia;
        protected $Categoria;
        protected $Sub_Categoria;

        // Definimos $grupo = null por seguridad para que no rompa llamadas con 10 argumentos
        function __construct($id, $grupo = null, $Nombre, $Descripcion, $Marca_Producto, $Marca_Vehiculo, $Presentacion, $imagen_url, $referencia, $Categoria, $Sub_Categoria)
        {
            $this->id = $id;
            $this->grupo = $grupo;
            $this->Nombre = $Nombre;
            $this->Descripcion = $Descripcion;
            $this->Marca_Producto = $Marca_Producto;
            $this->Marca_Vehiculo = $Marca_Vehiculo;
            $this->Presentacion = $Presentacion;
            $this->imagen_url = $imagen_url;
            $this->referencia = $referencia;
            $this->Categoria = $Categoria;
            $this->Sub_Categoria = $Sub_Categoria;
        }

        public function Getid(){
            return $this->id;
        }

        public function GetGrupo(){
            return $this->grupo;
        }
        
        public function GetNombre(){    
            return $this->Nombre;
        }
        
        public function GetDescripcion(){
            return $this->Descripcion;
        }
        
        public function GetMarca_Producto(){
            return $this->Marca_Producto;
        }
        
        public function GetMarca_Vehiculo(){
            return $this->Marca_Vehiculo;
        }
        
        public function GetPresentacion(){
            return $this->Presentacion; 
        }
        
        public function Getimagen_Url(){
            return $this->imagen_url;
        }
        
        public function GetReferencia(){
            return $this->referencia;
        }
        
        public function GetCategoria(){
            return $this->Categoria;
        }
        
        public function GetSub_Categoria(){
            return $this->Sub_Categoria;
        }

        public static function buscarPorId($id, $pdo) {
            $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
            $stmt->execute(['id' => $id]);
            
            $datos = $stmt->fetch(PDO::FETCH_ASSOC); 
            
            if (!$datos) {
                return null; 
            }
            
            // Usamos operador de fusión de null por si la columna no viniera en alguna fila
            return new self(
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

        public static function obtenerImagenesPorId($id, $pdo) {
            $stmt = $pdo->prepare("SELECT imagen_url FROM imagenes WHERE producto_id = :id");
            $stmt->execute(['id' => $id]);
            return $stmt->fetchAll(PDO::FETCH_COLUMN); 
        }
    }
?>