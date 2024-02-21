<?php

namespace App;

class ActiveRecord{
    //base de datos

    protected static $db;
    protected static $tabla = '';

    //errores
    protected static $errores = [];


    //definir la conexion a la db
    public static function setDB($database){
        self::$db = $database;
    }


    public function guardar(){
        if(!is_null($this->id)){
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
        $query = "INSERT INTO ". static::$tabla . "($columnas) VALUES ('$fila')";



        $resultado = self::$db->query($query);

        // debuguear($resultado);
        //Mensaje de exito 
        if($resultado){
            //redireccionar al usuario
            header('Location: /bienesraicesPOO/admin/index.php?resultado=1');
        }


    }

    public function actualizar(){
        $atributos = $this->sanatizarAtributos();

        $valores = [];
        foreach($atributos as $key => $value){
            $valores[] = "{$key}='{$value}'";
        }
        $query = "UPDATE ". static::$tabla ." SET ";
        $query .= join(', ', $valores);
        $query .= " WHERE id = '". self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 ";
        

       $resultado = self::$db->query($query);

     
       if($resultado){
        //redireccionar al usuario
        header('Location: /bienesraicesPOO/admin/index.php?resultado=2');
        }

    }

    //eliminar registro
    public function eliminar(){

        $query = "DELETE FROM ". static::$tabla . " WHERE id = " . self::$db->escape_string($this->id) . " LIMIT 1" ;
        $resultado = self::$db->query($query);

        if($resultado) {
            $this->eliminarImagen();
            header('Location: /bienesraicesPOO/admin/index.php?resultado=3');
        }
    }

    //identificar y unir los atributos de la bd
    public function atributos(){
        $atributos = [];
        foreach(static::$columnasDB as $columna) {
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
        if( !is_null($this->id) ){
            $this->eliminarImagen();
        }

        //asignar el atributo de la imagen el nombre de imagen
        if($imagen){
            $this->imagen = $imagen;
        }
    }

    //eliminar archivos 
    public function eliminarImagen(){
        //comprobar si existe archivo
        $existeArchivo = file_exists(CARPETA_IMAGENES . $this->imagen);
        if($existeArchivo){
            unlink(CARPETA_IMAGENES . $this->imagen);
        }
    }


    //validacion
    public static function getErrores(){
        return static::$errores;
    }

    public function validar(){

        static::$errores = [];
        return static::$errores;

    }

    //Lista todos las registros
    public static function all(){
   
        $query = "SELECT * FROM ". static::$tabla;


        $resultado = self::consultarSQL($query);

        return $resultado;

    }

    //obtiene determinado numero de registros
    public static function get($cantidad){
        $query = "SELECT * FROM ". static::$tabla . " LIMIT " . $cantidad;

        $resultado = self::consultarSQL($query);

        return $resultado;

    }

    //busca un registro por su id
    public static function find($id){
        $query = "SELECT * FROM ". static::$tabla . " where id = {$id}";
        $resultado = self::consultarSQL($query);

        return array_shift($resultado);
    }

    public static function consultarSQL($query){
        // consultar la base de datos
        $resultado = self::$db->query($query);

        //iterar los resultados
        $array = [];
        while($registro = $resultado->fetch_assoc()){
            $array[] = static::crearObjeto($registro);
        }


        //liberar la memoria
        $resultado->free();

        //retornar los resultados
        return $array;

    }

    protected static function crearObjeto($registro){
        $objeto = new static;

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