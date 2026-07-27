 <?php 
    class producto{ 

        protected $id;
        protected $Nombre;
        protected $Descripcion;
        protected $Marca_Producto;
        protected $Marca_Vehiculo;
        protected $Presentacion;
        protected $imagen_url;
        protected $referencia;
        protected $Categoria;
        protected $Sub_Categoria;

        function __construct($id, $Nombre, $Descripcion, $Marca_Producto, $Marca_Vehiculo, $Presentacion, $imagen_url, $referencia, $Categoria, $Sub_Categoria)
        {
            $this->id = $id;
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
            return $this->id;
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

        // Añade esto dentro de la clase Producto, al final
public static function buscarPorId($id, $pdo) {
    // 1. Preparar la consulta SQL para evitar inyecciones
    $stmt = $pdo->prepare("SELECT * FROM productos WHERE id = :id");
    $stmt->execute(['id' => $id]);
    
    // 2. Obtener el resultado como un array asociativo
    $datos = $stmt->fetch(PDO::getAvailableDrivers() ? PDO::FETCH_ASSOC : PDO::FETCH_ASSOC); 
    
    // Si no se encuentra el producto, retornamos null
    if (!$datos) {
        return null; 
    }
    
    // 3. Retornar una nueva instancia de la clase con los datos reales de la BD
    return new self(
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

public static function obtenerImagenesPorId($id, $pdo) {
    $stmt = $pdo->prepare("SELECT ruta_imagen FROM imagenes WHERE producto_id = :id");
    $stmt->execute(['id' => $id]);
    return $stmt->fetchAll(PDO::FETCH_COLUMN); // Devuelve un array con las rutas de las imágenes
}

    }