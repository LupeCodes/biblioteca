<?php
class EjemplarController extends Controller{
    
    //CREATE---------------------------------------------
    public function create(int $idlibro = 0){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        $libro = Libro::findOrFail($idlibro);
        
        return view('ejemplar/create',[
            'libro' => $libro
        ]);
    }
    
    
    
    //STORE-----------------------------------------------------------
    public function store(){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
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
    
    
    
    //EDIT------------------------------------------------------------
    public function edit(int $id = 0){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        //busca el libro con ese ID
        $ejemplar = Ejemplar::findOrFail($id, "No se encontró el ejemplar");
        
        //retornamos una ViewResponse con la vista con el formulario de edicion
        return view('ejemplar/edit', [
            'ejemplar' => $ejemplar
        ]);
    }
    
    
    //METODO UPDATE-----------------------------------------------------
    public function update(){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        //si no llega el formulario...
        if(!request()->has('actualizar'))
            //lanza la excepcion
            throw new FormException('No se recibieron datos');
            
            $id = intval(request()->post('id'));    //recuperar el id vía POST
            
            $ejemplar = Ejemplar::findOrFail($id, "No se ha encontrado el ejemplar.");
            
            $libro = $ejemplar->belongsTo('Libro');
            
            //recuperar el resto de campos
            $ejemplar->anyo       = intval(request()->post('anyo'));
            $ejemplar->precio     = floatval(request()->post('precio'));
            $ejemplar->estado     = request()->post('estado');
           
            $idlibro = $libro->id;
            //intentamos actualizar el libro
            try{
                $ejemplar->update();
                Session::success("Actualización del ejemplar correcta.");
                return redirect("/Libro/edit/$idlibro"); 
                
                
                //si se produce un error al guardar el libro
            }catch(SQLException $e){
                
                Session::error("Hubo errores en la actualización del ejemplar");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Libro/edit/$idlibro");
            }
            
    }//FIN DE UPDATE
    
    
    
    //DESTROY--------------------------------------------------------------------
    public function destroy(int $id = 0){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
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