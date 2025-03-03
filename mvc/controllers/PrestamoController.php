<?php
class PrestamoController extends Controller{
    
    //metodo por defecto
    public function index(){
        return $this->list();
    }
    
    
    //LISTADO DE PRESTAMOS-----------------------------------
    public function list(){
        
        //recupera todos los prestamos y los ordena por fecha de prestamo desc:
        $prestamos = V_prestamo::orderBy('prestamo','DESC');
        
        //carga la vista que los muestra
        //el view es un helper
        return view('prestamo/list',[
            'prestamos' => $prestamos
        ]);
    }
    
    
    //METODO CREATE-------------------------------------------
    public function create(){
        return view('prestamo/create');
    }
    
    
    
    //METODO STORE----------------------------------------------
    public function store(){
        
        //comprueba que la petición venga del formulario
        if(!request()->has('guardar'))
            //si la request NO tiene guardar lanza una excepcion
            throw new FormException('No se recibió el formulario');
            
            $prestamo = new Prestamo();   //creamos el nuevo Libro
            
            //toma los datos que llegan por POST
            //en la configuracion, las cadenas vacias las guarda como null
            //para poner un valor por defecto seria asi
            //y en la vista pondrias un condicional, y que si es menor que 0, pues no imprima nada
            $prestamo->idsocio      =request()->post('idsocio');
            $prestamo->idejemplar   =request()->post('idejemplar');
            $prestamo->limite       =request()->post('limite');
            
            
            //intenta guardar el libro. En caso de que la insercion falle
            //vamos a evitar ir a la página de error y volveremos
            //al formulario "nuevo libro"
            try{
                //guarda el libro en la base de datos
                $prestamo->save();
                
                //flashea un mensaje de éxito en la sesión
                Session::success("Guardado del prestamo correcto");
                
                //redirecciona a los detalles del libro que hemos guardado
                return redirect("/Socio/show/$prestamo->idsocio");
                
                //si falla el guardado del libro nos venimos al catch
            }catch(SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar el prestamo");
                
                //si está en modo DEBUG vuelve a lanzar la excepcion
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de libro
                    //los valores no deberían haberse borrado si usamos los helpers old()
                    return redirect("/Prestamo/create");
            }
    }//FIN DE FUNCION STORE
    
    
    //METODO DEVOLUCIÓN-------------------------------------------------------------------
    public function devolucion(int $id = 0){
        
        $prestamo = Prestamo::findOrFail($id, 'No se encontró el préstamo');
        
        $prestamo->devolucion = date('Y-m-d');
        
        
        //esto nos da la página actual, xq podemos llegar aquí desde dos sitios distintos
        //la vista de lista de prestamos, o la lista de los prestamos de un socio en la 
        //vista socio detalles
        $url = $_SERVER['HTTP_REFERER']; 
        
        try{
            $prestamo->update();
            
            Session::success("Se ha actualizado la devolución");
            
            return redirect("$url");
            //return redirect("/Prestamo/list");
            
        }catch(SQLException $e){
            
            Session::error("Hubo errores en la actualización de la devolución");
            
            if(DEBUG)
                throw new SQLException($e->getMessage());
                
                return redirect("$url");
                //return redirect("/Prestamo/list");
        }
        
        
    }//FIN DE METODO DEVOLUCION
    
    
    
    //METODO AMPLIAR-------------------------------------------------------------------
    public function ampliar(int $id = 0){
        
        //busca el prestamo con ese ID
        $prestamo = Prestamo::findOrFail($id, "No se encontró el prestamo");
        $vprestamo = V_prestamo::findOrFail($id, "No se encontró el prestamo");
        
        return view('Prestamo/ampliar',[
            'prestamo' => $prestamo ,
            'vprestamo'=> $vprestamo
        ]);
        
        
    }//FIN DE METODO AMPLIAR
    
    
    //METODO INCIDENCIA-------------------------------------------------------------------
    public function incidencia(int $id = 0){
        
        //busca el prestamo con ese ID
        $prestamo = Prestamo::findOrFail($id, "No se encontró el prestamo");
        $vprestamo = V_prestamo::findOrFail($id, "No se encontró el prestamo");
        
        return view('Prestamo/incidencia',[
            'prestamo' => $prestamo ,
            'vprestamo'=> $vprestamo
        ]);
        
        
    }//FIN DE METODO INCIDENCIA
    
    
    //METODO UPDATE
    public function update(){
        
        //si no llega el formulario...
        if(!request()->has('actualizar'))
            //lanza la excepcion
            throw new FormException('No se recibieron datos');
            
        $id = intval(request()->post('id'));    //recuperar el id vía POST
        //dd($id);
        
        
        $prestamo = Prestamo::findOrFail($id, "No se ha encontrado el ejemplar.");
            
         //dd($prestamo);
         
         
        //recuperar el resto de campos
        $prestamo->limite       = request()->post('limite');
        $prestamo->incidencia   = request()->post('incidencia');
            
        //intentamos actualizar el prestamo
        try{
            $prestamo->update();
            Session::success("Actualización del prestamo correcta");
            return redirect("/Socio/show/$prestamo->idsocio");
                
                
            //si se produce un error al guarda la actualizacion del prestamo
        }catch(SQLException $e){
                
            Session::error("Hubo errores en la actualización del prestamo");
                
            if(DEBUG)
                throw new SQLException($e->getMessage());
                    
                return redirect("/Socio/show/$idsocio");
            }
            
    }//FIN DE UPDATE
    
    
}//FIN DE LA CLASE