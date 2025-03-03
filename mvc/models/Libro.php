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
    
}//FIN DE LA CLASE