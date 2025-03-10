<?php
class Libro extends Model{
    
    //METODO ADDTEMA-------------------------------------------------------
    public function addTema(int $idtema):int{
        //preparamos la consulta
        $consulta = "INSERT INTO temas_libros(idlibro, idtema)
                        VALUES($this->id, $idtema)";
        //ejecutamos la consulta
        return (DB_CLASS)::insert($consulta);
    }//FIN ADDTEMA
    
    
    
    //METODO REMOVETEMA------------------------------------------------------
    public function removeTema(int $idtema):int{
        //preparamos la consulta
        $consulta = "DELETE FROM temas_libros
                    WHERE idlibro = $this->id AND idtema = $idtema";
        //ejecuta la consulta
        return (DB_CLASS)::delete($consulta);
    }//FIN REMOVETEMA
    
    
    
    
    //METODO VALIDATE---------------------------------------------------------
    //retorna los errores de validación de un Libro
    //Si no hay errores, retorna un array vacio
    ///el parametro $chekId indica si se debe hacer la comprobacion
    //sobre el campo id (no se hace en store, pero sí en update)
    public function validate(bool $checkId = false):array{
        $errores = [];
        
        //el campo id solo se comprueba en el update()
        if($chekId && empty(intval($this->id)))
            $errores['id'] = "No se indicó el identificador";
        
        //ISBN de 10 a 17 digitos o guiones medios
        if(empty($this->isbn) || !preg_match("/^\d[\d\-]{9,16}\d$/", $this->isbn))
            $errores['isbn'] = "Error en el formato del ISBN";
        
        //titulo: de 1 a 64 caracteres
        if(empty($this->titulo) || strlen($this->titulo)<1 || strlen($this->titulo)>64)
            $errores['titulo'] = "Error en la longitud del título";
        
        //edición: número positivo
        if(empty($this->edicion) || $this->edicion<0)
            $errores['edicion'] = "Error en la edicion";
        
        //edad recomendada: de 0 a 120
        if(empty($this->edadrecomendada) || $this->edadrecomendada<0 || $this->edadrecomendada>120)
            $errores['edadrecomendada'] = "Error en la edad recomendada";
        
        //Aquí si queremos realizar mas comprobaciones...  
        //editorial: de 1 a 64 caracteres
        if(empty($this->editorial) || strlen($this->editorial)<1 || strlen($this->editorial)>64)
            $errores['editorial'] = "Error en la longitud de la editorial";
        
        if(empty($this->autor) || strlen($this->autor)<1 || strlen($this->autor)>256)
            $errores['autor'] = "Error en la longitud de la editorial";
        
        if(empty($this->idioma) || strlen($this->idioma)<1 || strlen($this->idioma)>64)
            $errores['idioma'] = "Error en la longitud del idioma";
        
       // if(empty($this->portada) || strlen($this->portada)<1 || strlen($this->portada)>512)
       //     $errores['portada'] = "Error en la longitud de la portada";
        
        return $errores; //retorna la lista de errores
    }
    
    
}//FIN DE LA CLASE