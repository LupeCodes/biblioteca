<?php
class EjemplarController extends Controller{
    
    //CREATE---------------------------------------------
    public function create(int $idlibro = 0){
        
        $libro = Libro::findOrFail($idlibro);
        
        return view('ejemplar/create',[
            'libro' => $libro
        ]);
    }
    
    
    
    //STORE-----------------------------------------------------------
    public function store(){
        //comprobamos que el formulario llega con los datos
        if(!request()->has('guardar'))
            throw new FormException('No se recibieron los datos del ejemplar');
        
        $ejemplar = new Ejemplar();
        
        $ejemplar->idlibro  = intval(request()->post('idlibro'));
        $ejemplar->anyo     = intval(request()->post('anyo'));
        $ejemplar->precio   = floatval(request()->post('precio'));
        $ejemplar->estado   = request()->post('estado');
        
        //intentamos guardarlo en la bdd
        try{
            $ejemplar->save();
            
            Session::success('El ejemplar se ha añadido correctamente');
            return redirect("/Libro/edit/$ejemplar->idlibro");
        }catch(SQLException $e){
            
            Session::error('No se ha podido añadir el ejemplar');
            
            if(DEBUG)
                throw new Exception($e->getMessage());
            
            return redirect("/Ejemplar/create/$ejemplar->idlibro");
        }
        
    }//FIN DE STORE
    
    
    
    //DESTROY--------------------------------------------------------------------
    public function destroy(int $id = 0){
        
        //lo recuperamos de la BDD
        $ejemplar = Ejemplar::findOrFail($id, "No se encontró el ejemplar");
        
        //si hay prestamos no permitimos el borrado
        if($ejemplar->hasAny('Prestamo', 'idejemplar'))
            throw new Exception('Este ejemplar no se puede borrar, tiene préstamos');
        
        try{
            $ejemplar->deleteObject();
            Session::Success('Ejemplar eliminado correctamente.');
            return redirect("/Libro/edit/$ejemplar->idlibro");
                
        }catch(SQLException $e){
                
            Session::error('No se pudo eliminar el ejemplar');
                
            if(DEBUG)
                throw new Exception($e->getMessage());
                
            return redirect("Libro/edit/$ejemplar->idlibro");
        }
    }//FIN DE DESTROY
    
}//FIN DE LA CLASE