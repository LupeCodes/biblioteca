<?php
class TemaController extends Controller{
    
    //metodo por defecto
    public function index(){
        return $this->list();
    }
    
    
    //LISTADO DE TEMAS-----------------------------------
    public function list(int $page = 1){
        
        $filtro = Filter::apply('temas');
        $limit = RESULTS_PER_PAGE;  //numero de resultados x pagina, en el config
        
        //si hay filtro
        if($filtro){
            //recuperamos el total de temas q cumplen el filtro
            $total = Tema::filteredResults($filtro);
            //el objeto paginador
            $paginator = new Paginator('/Tema/list', $page, $limit, $total);
            
            //recupera los temas que cumplen los criterios de filtro
            $temas = Tema::filter($filtro, $limit, $paginator->getOffset());
          
        }else{
            $total = Tema::total();    //el total de libros q hay
            
            //el objeto paginador
            $paginator = new Paginator('/Tema/list', $page, $limit, $total);
            
            //recupera todos los temas y los ordena por id
            //$temas = Tema::all();
            
            //para ordenarlos por titulo, por ejemplo, sería así:
            $temas = Tema::orderBy('tema','ASC', $limit, $paginator->getOffset());
        }
            
        //carga la vista que los muestra
        //el view es un helper
        return view('tema/list',[
            'temas'     => $temas,
            'paginator' => $paginator
        ]);
    }
    
    
    //DETALLES DEL TEMA---------------------------------------
    public function show(int $id = 0){
        
        //lo buscamos con findOrFail porque nos ahorra hacer más comprobaciones
        $tema = Tema::findOrFail($id);    //busca el tema con ese ID
        
        $libros = $tema->belongsToMany('Libro', 'temas_libros');
        
        
        //carga la vista y le pasa el tema recuperado
        return view('tema/show',[
            'tema' => $tema,
            'libros' => $libros
        ]);
    }
    
    
    //METODO CREATE-------------------------------------------
    public function create(){
        return view('tema/create');
    }
    
    
    
    //METODO STORE----------------------------------------------
    public function store(){
        
        //comprueba que la petición venga del formulario
        if(!request()->has('guardar'))
            //si la request NO tiene guardar lanza una excepcion
            throw new FormException('No se recibió el formulario');
            
            $tema = new Tema();   //creamos el nuevo Tema
            
            //toma los datos que llegan por POST
            //en la configuracion, las cadenas vacias las guarda como null
            //para poner un valor por defecto seria asi
            //y en la vista pondrias un condicional, y que si es menor que 0, pues no imprima nada
            $tema->tema             =request()->post('tema');
            $tema->descripcion      =request()->post('descripcion');
            
            
            //intenta guardar el tema. En caso de que la insercion falle
            //vamos a evitar ir a la página de error y volveremos
            //al formulario "nuevo tema"
            try{
                //guarda el tema en la base de datos
                $tema->save();
                
                //flashea un mensaje de éxito en la sesión
                Session::success("Guardado del tema $tema->tema correcto");
                
                //redirecciona a los detalles del tema que hemos guardado
                return redirect("/Tema/show/$tema->id");
                
                //si falla el guardado del tema nos venimos al catch
            }catch(SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar el tema $tema->tema");
                
                //si está en modo DEBUG vuelve a lanzar la excepcion
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de tema
                    //los valores no deberían haberse borrado si usamos los helpers old()
                    return redirect("/Tema/create");
            }
    }//FIN DE FUNCION STORE
    
    
    //EDIT------------------------------------------------------------
    public function edit(int $id = 0){
        
        //busca el tema con ese ID
        $tema = Tema::findOrFail($id, "No se encontró el tema");
        
        //retornamos una ViewResponse con la vista con el formulario de edicion
        return view('tema/edit', [
            'tema' => $tema
        ]);
    }
    
    
    //METODO UPDATE-----------------------------------------------------
    public function update(){
        
        //si no llega el formulario...
        if(!request()->has('actualizar'))
            //lanza la excepcion
            throw new FormException('No se recibieron datos');
            
            $id = intval(request()->post('id'));    //recuperar el id vía POST
            
            $tema = Tema::findOrFail($id, "No se ha encontrado el tema.");
            
            //recuperar el resto de campos
            $tema->tema             = request()->post('tema');
            $tema->descripcion      = request()->post('descripcion');
            
            //intentamos actualizar el tema
            try{
                $tema->update();
                Session::success("Actualización del tema $tema->titulo correcta.");
                return redirect("/Tema/edit/$id");
                
                //si se produce un error al guardar el tema
            }catch(SQLException $e){
                
                Session::error("Hubo errores en la actualización del tema $tema->titulo");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Tema/edit/$id");
            }
            
    }
    
    
    //METODO DELETE--------------------------------------------
    public function delete(int $id = 0){
        
        $tema = Tema::findOrFail($id, "No existe el tema");
        
        return view('tema/delete', [
            'tema' => $tema
        ]);
    }
    
    
    
    //METODO DESTROY----------------------------------------------------------
    public function destroy(){
        
        //comprueba que llega el formulario de confirmación
        if(!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación');
            
            //recupera el identificador (id)
            $id     = intval(request()->post('id'));
            //con el id, recuperamos el tema
            $tema  = Tema::findOrFail($id);
            
            
            //más adelante, ocultaremos el botón borrar en estos casos
            //para que el usuario no llegue al formulario de confirmación
            
            try{
                $tema->deleteObject();
                Session::success("Se ha borrado el tema $tema->tema. Estarás contento");
                return redirect("/Tema/list");
                    
                    //si se produce unerror en la operacion con la BDD salta el catch
           }catch(SQLException $e){
                    
                Session::error("No se pudo borrar el tema $tema->tema");
                    
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                        
                    return redirect("/Tema/delete/$id");
           }
    }
    
    
    
}//FIN DE LA CLASE