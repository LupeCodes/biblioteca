<?php
class SocioController extends Controller{
    
    //metodo por defecto
    public function index(){
        return $this->list();
    }
    
    
    //LISTADO DE SOCIOS-----------------------------------
    public function list(int $page = 1){
        
        //analiza si hay filtros, pone uno nuevo o quita el existente
        $filtro = Filter::apply('socios');
        
        $limit = RESULTS_PER_PAGE;  //numero de resultados x pagina, en el config
        
        //si hay filtro
        if($filtro){
            //recuperamos el total de socios que cumplen los criterios
            $total = Socio::filteredResults($filtro);
            
            //creamos el paginador
            $paginator = new Paginator('/Libro/list', $page, $limit, $total);
            
            //recupera los socios que cumplen los criterios del filtro
            $socios = Socio::filter($filtro, $limit, $paginator->getOffset());
        }else{
        
            $total = Socio::total();    //el total de libros q hay
            
            //el objeto paginador
            $paginator = new Paginator('/Socio/list', $page, $limit, $total);
            
            //recupera todos los socios y los ordena por id
            $socios = Socio::orderBy('alta', 'ASC', $limit, $paginator->getOffset());
        }
        
        //carga la vista que los muestra
        return view('socio/list',[
            'socios'    => $socios,
            'paginator' => $paginator,
            'filtro'    => $filtro
        ]);
    }
    
    
    
    //DETALLES DEL SOCIO---------------------------------------
    public function show(int $id = 0){
        
        //lo buscamos con findOrFail porque nos ahorra hacer más comprobaciones
        $socio = Socio::findOrFail($id);    //busca el socio con ese ID
        
        $vprestamos = $socio->hasMany('V_prestamo');
        
        //dd($vprestamos);
        //carga la vista y le pasa el socio recuperado
        return view('socio/show',[
            'socio' => $socio,
            'vprestamos' => $vprestamos
        ]);
    }
    
    
    
    //METODO CREATE-------------------------------------------
    public function create(){
        return view('socio/create');
    }
    
    
    //METODO STORE----------------------------------------------
    public function store(){
        
        //comprueba que la petición venga del formulario
        if(!request()->has('guardar'))
            //si la request NO tiene guardar lanza una excepcion
            throw new FormException('No se recibió el formulario');
            
            $socio = new Socio();   //creamos el nuevo Libro
            
            //toma los datos que llegan por POST
            //en la configuracion, las cadenas vacias las guarda como null
            //para poner un valor por defecto seria asi
            //y en la vista pondrias un condicional, y que si es menor que 0, pues no imprima nada
            $socio->dni             =request()->post('dni');
            $socio->nombre          =request()->post('nombre');
            $socio->apellidos       =request()->post('apellidos');
            $socio->nacimiento      =request()->post('nacimiento');
            $socio->email           =request()->post('email');
            $socio->direccion       =request()->post('direccion');
            $socio->cp              =request()->post('cp');
            $socio->poblacion       =request()->post('poblacion');
            $socio->provincia       =request()->post('provincia');
            $socio->telefono        =request()->post('telefono');


            
            //intenta guardar el socio. En caso de que la insercion falle
            //vamos a evitar ir a la página de error y volveremos
            //al formulario "nuevo socio"
            try{
                //guarda el socio en la base de datos
                $socio->save();
                
                //flashea un mensaje de éxito en la sesión
                Session::success("Guardado del socio $socio->nombre correcto");
                
                //redirecciona a los detalles del socio que hemos guardado
                return redirect("/Socio/show/$socio->id");
                
                //si falla el guardado del socio nos venimos al catch
            }catch(SQLException $e){
                
                //flashea un mensaje de error en sesión
                Session::error("No se pudo guardar el socio $socio->nombre");
                
                //si está en modo DEBUG vuelve a lanzar la excepcion
                //esto hará que acabemos en la página de error
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    //regresa al formulario de creación de libro
                    //los valores no deberían haberse borrado si usamos los helpers old()
                    return redirect("/Socio/create");
            }
    }//FIN DE FUNCION STORE
    
    
    
    //EDIT------------------------------------------------------------
    public function edit(int $id = 0){
        
        //busca el libro con ese ID
        $socio = Socio::findOrFail($id, "No se encontró el socio");
        
        //retornamos una ViewResponse con la vista con el formulario de edicion
        return view('socio/edit', [
            'socio' => $socio
        ]);
    }
    
    
    //METODO UPDATE-----------------------------------------------------
    public function update(){
        
        //si no llega el formulario...
        if(!request()->has('actualizar'))
            //lanza la excepcion
            throw new FormException('No se recibieron datos');
            
            $id = intval(request()->post('id'));    //recuperar el id vía POST
            
            $socio = Socio::findOrFail($id, "No se ha encontrado el socio.");
            
            //recuperar el resto de campos
            $socio->dni             = request()->post('dni');
            $socio->nombre          = request()->post('nombre');
            $socio->apellidos       = request()->post('apellidos');
            $socio->nacimiento      = request()->post('nacimiento');
            $socio->email           = request()->post('email');
            $socio->direccion       = request()->post('direccion');
            $socio->cp              = request()->post('cp');
            $socio->provincia       = request()->post('provincia');
            $socio->poblacion       = request()->post('poblacion');
            $socio->telefono        = request()->post('telefono');
            
            
            //intentamos actualizar el socio
            try{
                $socio->update();
                Session::success("Actualización del socio $socio->nombre $socio->apellidos correcta.");
                return redirect("/Socio/edit/$id");
                
                //si se produce un error al guardar el socio
            }catch(SQLException $e){
                
                Session::error("Hubo errores en la actualización del socio $socio->nombre $socio->apellidos");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Socio/edit/$id");
            }
            
    }
    
    
    
    
    //METODO DELETE--------------------------------------------
    public function delete(int $id = 0){
        
        $socio = Socio::findOrFail($id, "No existe el socio");
        
        return view('socio/delete', [
            'socio' => $socio
        ]);
    }
    
    
    //METODO DESTROY----------------------------------------------------------
    public function destroy(){
        
        //comprueba que llega el formulario de confirmación
        if(!request()->has('borrar'))
            throw new FormException('No se recibió la confirmación');
            
            //recupera el identificador (id)
            $id     = intval(request()->post('id'));
            //con el id, recuperamos el socio
            $socio  = Socio::findOrFail($id);
            
            //si el libro tiene ejemplares, no permitiremos su borrados
            //más adelante, ocultaremos el botón borrar en estos casos
            //para que el usuario no llegue al formulario de confirmación
            if($socio->hasAny('Prestamo'))
                throw new Exception("No se puede borrar el socio mientras tenga prestamos");
                
                //intentamos borrar el libro
                try{
                    $socio->deleteObject();
                    Session::success("Se ha borrado el socio $socio->nombre $socio->apellidos. Estarás contento");
                    return redirect("/Socio/list");
                    
                    //si se produce unerror en la operacion con la BDD salta el catch
                }catch(SQLException $e){
                    
                    Session::error("No se pudo borrar el socio $socio->nombre $socio->apellidos");
                    
                    if(DEBUG)
                        throw new SQLException($e->getMessage());
                        
                        return redirect("/Socio/delete/$id");
                }
    }
    
    
    
    
    
}//FIN DE LA CLASE