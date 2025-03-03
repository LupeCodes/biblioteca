<?php
class LibroController extends Controller{
    
    //metodo por defecto
    public function index(){
        return $this->list();
    }
    
    
    //LISTADO DE LIBROS-----------------------------------
    public function list(){
        
        //recupera todos los libros y los ordena por id
        //$libros = Libro::all(); 
        
        //para ordenarlos por titulo, por ejemplo, sería así:
        $libros = Libro::orderBy('titulo','ASC');
        
        //carga la vista que los muestra
        //el view es un helper
        return view('libro/list',[
            'libros' => $libros
        ]);
    }
    
    
    //DETALLES DEL LIBRO---------------------------------------
    public function show(int $id = 0){
        
        //lo buscamos con findOrFail porque nos ahorra hacer más comprobaciones
        $libro = Libro::findOrFail($id);    //busca el libro con ese ID
        $ejemplares = $libro->hasMany('Ejemplar');
        $temas = $libro->belongsToMany('Tema', 'temas_libros');
        
        //carga la vista y le pasa el libro recuperado
        return view('libro/show',[
            'libro' => $libro,
            'ejemplares' => $ejemplares,
            'temas' => $temas
        ]);
    }
    
    
    //METODO CREATE-------------------------------------------
    public function create(){
        return view('libro/create',[
            'listaTemas' => Tema::orderby('tema')
        ]);
    }
    
    
    //METODO STORE----------------------------------------------
    public function store(){
        
        //comprueba que la petición venga del formulario
        if(!request()->has('guardar'))
            //si la request NO tiene guardar lanza una excepcion
            throw new FormException('No se recibió el formulario');
        
        $libro = new Libro();   //creamos el nuevo Libro
        
        //toma los datos que llegan por POST
        //en la configuracion, las cadenas vacias las guarda como null
        //para poner un valor por defecto seria asi
        //y en la vista pondrias un condicional, y que si es menor que 0, pues no imprima nada
        $libro->paginas             =request()->post('paginas' ?? -1);
        $libro->isbn                =request()->post('isbn');
        $libro->titulo              =request()->post('titulo');
        $libro->editorial           =request()->post('editorial');
        $libro->autor               =request()->post('autor');
        $libro->idioma              =request()->post('idioma');
        $libro->edicion             =request()->post('edicion');
        $libro->anyo                =request()->post('anyo');
        $libro->edadrecomendada     =request()->post('edadrecomendada');
        //$libro->paginas             =request()->post('paginas');
        $libro->caracteristicas     =request()->post('caracteristicas');
        $libro->sinopsis            =request()->post('sinopsis');
        
        //recupera el idtema del desplegable
        $idtema = intval(request()->post('idtema'));
        
        //intenta guardar el libro. En caso de que la insercion falle
        //vamos a evitar ir a la página de error y volveremos
        //al formulario "nuevo libro"
        try{
            //guarda el libro en la base de datos
            $libro->save();
            $libro->addTema($idtema);
            
            //flashea un mensaje de éxito en la sesión
            Session::success("Guardado del libro $libro->titulo correcto");
            
            //redirecciona a los detalles del libro que hemos guardado
            return redirect("/Libro/show/$libro->id");
        
        //si falla el guardado del libro nos venimos al catch
        }catch(SQLException $e){
            
            //flashea un mensaje de error en sesión
            Session::error("No se pudo guardar el libro $libro->titulo");

            //si está en modo DEBUG vuelve a lanzar la excepcion
            //esto hará que acabemos en la página de error
            if(DEBUG)
                throw new SQLException($e->getMessage());
            
            //regresa al formulario de creación de libro
            //los valores no deberían haberse borrado si usamos los helpers old()
            return redirect("/Libro/create");
        }
    }//FIN DE FUNCION STORE
    
    
    //EDIT------------------------------------------------------------
    public function edit(int $id = 0){
        
        //busca el libro con ese ID
        $libro = Libro::findOrFail($id, "No se encontró el libro");
        $ejemplares = $libro->hasMany('Ejemplar');
        //recuperamos los temas del libro
        $temas = $libro->belongsToMany('Tema', 'temas_libros');
        
        //recuperamos la lista completa de temas
        $listaTemas = array_diff(Tema::orderBy('tema'), $temas);
        
        //retornamos una ViewResponse con la vista con el formulario de edicion
        return view('libro/edit', [
            'libro'      => $libro,
            'ejemplares' => $ejemplares,
            'temas'      => $temas,
            'listaTemas' => $listaTemas
        ]);
    }
    
    
    //METODO UPDATE-----------------------------------------------------
    public function update(){
        
        //si no llega el formulario...
        if(!request()->has('actualizar'))
            //lanza la excepcion
            throw new FormException('No se recibieron datos');
        
        $id = intval(request()->post('id'));    //recuperar el id vía POST
        
        $libro = Libro::findOrFail($id, "No se ha encontrado el libro.");
        
        //recuperar el resto de campos
        $libro->paginas             = request()->post('paginas' ?? -1);
        $libro->isbn                = request()->post('isbn');
        $libro->titulo              = request()->post('titulo');
        $libro->editorial           = request()->post('editorial');
        $libro->autor               = request()->post('autor');
        $libro->idioma              = request()->post('idioma');
        $libro->edicion             = request()->post('edicion');
        $libro->anyo                = request()->post('anyo');
        $libro->edadrecomendada     = request()->post('edadrecomendada');
        //$libro->paginas             = request()->post('paginas');
        $libro->caracteristicas     = request()->post('caracteristicas');
        $libro->sinopsis            = request()->post('sinopsis');
        
        //intentamos actualizar el libro
        try{
            $libro->update();
            Session::success("Actualización del libro $libro->titulo correcta.");
            return redirect("/Libro/edit/$id");
            
        //si se produce un error al guardar el libro
        }catch(SQLException $e){
            
            Session::error("Hubo errores en la actualización del libro $libro->titulo");
            
            if(DEBUG)
                throw new SQLException($e->getMessage());
            
            return redirect("/Libro/edit/$id");
        }
        
    }
    
    
    
    //METODO DELETE--------------------------------------------
    public function delete(int $id = 0){
        
        $libro = Libro::findOrFail($id, "No existe el libro");
        
        return view('libro/delete', [
            'libro' => $libro
        ]);
    }
    
    
    
    
    //METODO DESTROY----------------------------------------------------------
    public function destroy(){
        
        //comprueba que llega el formulario de confirmación
        if(!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación');
        
        //recupera el identificador (id)
        $id     = intval(request()->post('id'));
        //con el id, recuperamos el libro
        $libro  = Libro::findOrFail($id);
        
        //si el libro tiene ejemplares, no permitiremos su borrados
        //más adelante, ocultaremos el botón borrar en estos casos
        //para que el usuario no llegue al formulario de confirmación
        if($libro->hasAny('Ejemplar'))
            throw new Exception("No se puede borrar el libro mientras tenga ejemplares");
        
        //intentamos borrar el libro
            try{
                $libro->deleteObject();
                Session::success("Se ha borrado el libro $libro->titulo. Estarás contento");
                return redirect("/Libro/list");
                
            //si se produce unerror en la operacion con la BDD salta el catch    
            }catch(SQLException $e){
                
                Session::error("No se pudo borrar el libro $libro->titulo");

                if(DEBUG)
                    throw new SQLException($e->getMessage());
                
                return redirect("/Libro/delete/$id");    
            }
    }
    
    
    //METODO ADDTEMA--------------------------------------------------
    public function addTema(){
        
        if (empty(request()->post('add')))
            throw new FormException("No se recibió el formulario.");
        
        //recupera los identificadores necesarios (idlibro e idtema)
        $idlibro = intval(request()->post('idlibro'));
        $idtema  = intval(request()->post('idtema'));
        
        //recupera las entidades libro y tema
        $libro  = Libro::findOrFail($idlibro, "No se encontró el libro");
        $tema   = Tema::findOrFail($idtema, "No se encontró el tema");
        
        //dd($tema);
        //intentamos vincular el tema al libro
        try{
            $libro->addTema($idtema);
            Session::success("Se ha añadido $tema->tema a $libro->titulo");
            return redirect("/Libro/edit/$idlibro");
        //y si no lo consigue...
        }catch(SQLException $e){
            
            Session::error("No se pudo añadir $tema->tema a $libro->titulo");
            
            if(DEBUG)
                throw new Exception($e->getMessage());
            
            return redirect("/Libro/edit/$idlibro");
        }
    }//FIN ADDTEMA
    
    
    
    //METODO REMOVETEMA----------------------------------------------------------
    public function removetema(){
        //comprueba que llega el formulario
        if(empty(request()->post('idlibro')))
            throw new FormException("No se recibió el formulario");
        
        //recupera los identificadores necesarios (idlibro e idtema)
        $idlibro = intval(request()->post('idlibro'));
        $idtema  = intval(request()->post('idtema'));
            
        //recupera las entidades libro y tema
        $libro  = Libro::findOrFail($idlibro, "No se encontró el libro");
        $tema   = Tema::findOrFail($idtema, "No se encontró el tema");
        
        //intenta quitar el tema al libro
        try{
            $libro->removeTema($idtema);
            Session::success("Se ha eliminado $tema->tema de $libro->titulo");
            return redirect("/Libro/edit/$idlibro");
        //y si se produce un error...    
        }catch(SQLException $e){
            Session::error("No se pudo eliminar $tema->tema de $libro->titulo");
            
            if(DEBUG)
                throw new SQLException($e->getMessage());
            return redirect("/Libro/edit/$idlibro");
        }
        
        
    }//FIN DE REMOVETEMA
    
    
    
    
}//FIN DE LA CLASE