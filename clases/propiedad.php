<?php

namespace App;


class Propiedad{
    //base de datos

    protected static $db;
    protected static $columnasDB = ['id', 'titulo', 'precio', 'imagen', 'descripcion', 'habitaciones', 'wc', 'estacionamiento',
    'creado', 'vendedores_id' ];

    //errores
    protected static $errores = [];


    public $id;
    public $titulo;
    public $precio;
    public $imagen;
    public $descripcion;
    public $habitaciones;
    public $wc;
    public $estacionamiento;
    public $creado;
    public $vendedores_id;


    //definir la conexion a la db
    public static function setDB($database){
        self::$db = $database;
    }

    public function __construct($args = [])
    {  
        $this->id = $args['id'] ?? '';
        $this->titulo = $args['titulo'] ?? '';
        $this->precio = $args['precio'] ?? '';
        $this->imagen = $args['imagen'] ?? '';
        $this->descripcion = $args['descripcion'] ?? '';
        $this->habitaciones = $args['habitaciones'] ?? '';
        $this->wc = $args['wc'] ?? '';
        $this->estacionamiento = $args['estacionamiento'] ?? '';
        $this->creado = date('Y/m/d');
        $this->vendedores_id = $args['vendedores_id'] ?? 1;


        
    }
    public function guardar(){
        if(isset($this->id)){
            $this->actualizar();
        }else{
            $this->crear();
        }
    }

    public function crear(){

        //Sanitizar los datos
        $atributos = $this->sanatizarAtributos();

      
        
        //insertar en la base de datos Forma del profe
/*      $query = "INSERT INTO propiedades ("; 
        $query.= join(', ', array_keys($atributos));
        $query.= " ) VALUES (' "; 
        $query.= join("', '", array_values($atributos));
        $query.= " ') "; */

    //insertar en la base de datos Forma mas legible
        $columnas = join(', ',array_keys($atributos));
        $fila = join("', '",array_values($atributos));

        // Consulta para insertar datos
        $query = "INSERT INTO propiedades($columnas) VALUES ('$fila')";
        $resultado = self::$db->query($query);

        return $resultado;
    }

    public function actualizar(){
        $atributos = $this->sanatizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }
        $query = "UPDATE propiedades SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '". self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1";

       $resultado = self::$db->query($query);

       if($resultado){
        //redireccionar al usuario
        header('Location: /bienesraicesPOO/admin/index.php?resultado=2');
        }

    }

    //identificar y unir los atributos de la bd
    public function atributos(){
        $atributos = [];
        foreach(self::$columnasDB as $columna) {
            if($columna == 'id') continue;
            $atributos[$columna] = $this->$columna;

        }
        return $atributos;
    }


    //sanitizar 
    public function sanatizarAtributos(){
        $atributos = $this->atributos();
        $sanitizado = [];
        

        foreach($atributos as $key => $value){
            $sanitizado[$key] = self::$db->escape_string($value);
        }

        return $sanitizado;
    }

    //subida de archivos
    public function setImagen($imagen){
        //elimina la imagen previa
        if(isset($this->id)){
            //comprobar si existe archivo
            $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
            if($existeArchivo){
                unlink(CARPETA_IMAGENES . $this->imagen);
            }
        }

        //asignar el atributo de la imagen el nombre de imagen
        if($imagen){
            $this->imagen = $imagen;
        }
    }


    //validacion
    public static function getErrores(){
        return self::$errores;
    }

    public function validar(){
        
        if(!$this->titulo){
            self::$errores[] = "debes añadir un titulo";
        }

        if(!$this->precio){
            self::$errores[] = "debes añadir un precio";
        }

        if( strlen($this->descripcion) < 50){
            self::$errores[] = "La descripcion es obligatoria y debe tener menos de 50 caracteres";
        }

        if(!$this->habitaciones){
            self::$errores[] = "debes añadir una habitacion";
        }

        if(!$this->wc){
            self::$errores[] = "debes añadir un baño";
        }

        if(!$this->estacionamiento){
            self::$errores[] = "debes añadir un estacionamiento";
        }

        if(!$this->vendedores_id){
            self::$errores[] = "debes añadir un vendedor";
        }

        if(!$this->imagen){
            self::$errores[] = "la imagen es Obligatorio";
        }

        return self::$errores;

    }

    //Lista todos las registros
    public static function all(){
   
        $query = "SELECT * FROM propiedades";
        $resultado = self::consultarSQL($query);

        return $resultado;

    }

    //busca un registro por su id
    public static function find($id){
        $query = "SELECT * FROM propiedades where id = {$id}";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function consultarSQL($query){
        // consultar la base de datos
        $resultado = self::$db->query($query);

        //iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = self::crearObjeto($registro);
        }


        //liberar la memoria
        $resultado->free();

        //retornar los resultados
        return $array;

    }

    protected static function crearObjeto($registro){
        $objeto = new self;

        foreach($registro as $key => $value){
            if( property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        }
        return $objeto;
    }

    //sincroniza el objeto en memoria con los cambios realizados por el usuario
    public function sincronizar( $args = []){
        foreach($args as $key => $value){
            if(property_exists($this, $key) && !is_null($value)){
                $this->$key = $value;
            }
        }
    }
}