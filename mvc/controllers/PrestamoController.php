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
    
}//FIN DE LA CLASE