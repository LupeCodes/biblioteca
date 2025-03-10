<?php
class Socio extends Model{
    
    //METODO VALIDATE-----------------------------------
    //retorna los errores de validacion de un socio
    //si no hay errores, array vacio
    public function validate(bool $checkId = false):array{
        $errores = [];
        
        //el campo id solamente se comprueba en el update()
        if($checkId && empty(intval($this->id)))
            $errores['id'] = "No se indicó el identificador";
        
        //DNI o NIE
        if(empty($this->dni) || !preg_match("/^[XYZ\d]\d{7}[A-Z]$/i", $this->dni))
            $errores['dni'] = "Error en el formato del dni";
        
        //Nombre
        if(empty($this->nombre) || strlen($this->nombre)<1 || strlen($this->nombre)>64)
            $errores['nombre'] = "Error en la longitud del nombre";
        
       //Apellidos
        if(empty($this->apellidos) || strlen($this->apellidos)<1 || strlen($this->apellidos)>128)
            $errores['apellidos'] = "Error en la longitud de los apellidos";
       
        //email
        if(empty($this->email) || !preg_match("/^[\w]+@[a-zA-Z0-9-]+.[a-zA-Z]+$/", $this->email))
            $errores['email'] = "Error en el formato del email";
        
        //Direccion
        if(empty($this->direccion) || strlen($this->direccion)<1 || strlen($this->direccion)>128)
            $errores['direccion'] = "Error en la longitud de la direccion";
        
        return $errores; //retorna la lista de errores
        
    }// FIN DEL VALIDATE
    
}//FIN DE LA CLASE