<?php
class SocioController extends Controller{
    
    //metodo por defecto
    public function index(){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        return $this->list();
    }
    
    
    //LISTADO DE SOCIOS-----------------------------------
    public function list(int $page = 1){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        //analiza si hay filtros, pone uno nuevo o quita el existente
        $filtro = Filter::apply('socios');
        
        $limit = RESULTS_PER_PAGE;  //numero de resultados x pagina, en el config
        
        //si hay filtro
        if($filtro){
            //recuperamos el total de socios que cumplen los criterios
            $total = Socio::filteredResults($filtro);
            
            //creamos el paginador
            $paginator = new Paginator('/Socio/list', $page, $limit, $total);
            
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
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
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
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        return view('socio/create');
    }
    
    
    //METODO STORE----------------------------------------------
    public function store(){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
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
                //Primero validamos los campos
                if($errores = $socio->validate())
                    throw new ValidationException(
                        "<br>".arrayToString($errores, false, false, ".<br>")
                        );
                
                //guarda el socio en la base de datos
                $socio->save();
                
                //recupera la foto como objeto UploadedFile
                $file = request()->file(
                    'foto',     //nombre del input
                    8000000,    //tamaño maximo del fichero
                    ['image/png', 'image/jpeg', 'image/gif', 'image/webp']  //tipos aceptados
                    );
                
                //si hay fichero lo guardamos y actualizamos el campo foto
                if($file){
                    $socio->foto = $file->store('../public/'.MEMBER_IMAGE_FOLDER, 'socio_');
                    $socio->update(); //actualiza el socio para añadir la foto
                }
                
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
            //si falla el guardado de la foto
            }catch(UploadException $e){
                //preparamos un mensaje de advertencia
                //no da error, puesto que el socio se guardó
                Session::warning("El socio se guardó correctamente,
                                    pero no se pudo subir la foto");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                //redirigimos a la edicion del socio
                //por si se quiere volver a subir la foto
                redirect("/Socio/edit/$socio->id");
            //el catch del validate
            }catch(ValidationException $e){
                Session::error("Errores de validación. ".$e->getMessage());
                //regresa al formulario de creacion de socio
                return redirect("/socio/create");
            }
    }//FIN DE FUNCION STORE
    
    
    
    //EDIT------------------------------------------------------------
    public function edit(int $id = 0){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        //busca el libro con ese ID
        $socio = Socio::findOrFail($id, "No se encontró el socio");
        
        //retornamos una ViewResponse con la vista con el formulario de edicion
        return view('socio/edit', [
            'socio' => $socio
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
                //primero validamos
                if($errores = $socio->validate())
                    throw new ValidationException(
                        "<br>".arrayToString($errores, false, false,".<br>")
                        );
                
                //y luego ya updateamos
                $socio->update();
                
                //ahora recupera la portada como objeto UploadedFile (o null si no llega)
                $file = request()->file(
                    'foto',  //nombre del input
                    8000000,    //tamaño maximo del fichero
                    ['image/png', 'image/jpeg', 'image/gif', 'image/webp']  //tipos aceptados
                    );
                
                //dd($file);
                //si llega un nuevo fichero...
                if($file){
                    if($socio->foto) //si el socio ya tenia foto, la elimina
                        File::remove('../public/'.MEMBER_IMAGE_FOLDER.'/'.$socio->foto);
                    
                    //coloca el nuevo fichero (portada) y actualiza la propiedad
                    $socio->foto = $file->store('../public/'.MEMBER_IMAGE_FOLDER,'socio_');
                    $socio->update();   //actualiza solamente el campo portada
                }
                
                Session::success("Actualización del socio $socio->nombre $socio->apellidos correcta.");
                return redirect("/Socio/edit/$id");
                
                //si se produce un error al guardar el socio
            }catch(SQLException $e){
                
                Session::error("Hubo errores en la actualización del socio $socio->nombre $socio->apellidos");
                
                if(DEBUG)
                    throw new SQLException($e->getMessage());
                    
                    return redirect("/Socio/edit/$id");
            //si falla la actualizacion de la foto
            }catch(UploadException $e){
                Session::warning("Cambios guardados, pero no se modificó la foto");
                
                if(DEBUG)
                    throw new UploadException($e->getMessage());
                    
                    return redirect("/Socio/edit/$id"); //redirecciona a la edicion
            }
            
    }//FIN UPDATE
    
    
    
    
    //METODO DELETE--------------------------------------------
    public function delete(int $id = 0){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        $socio = Socio::findOrFail($id, "No existe el socio");
        
        return view('socio/delete', [
            'socio' => $socio
        ]);
    }
    
    
    //METODO DESTROY----------------------------------------------------------
    public function destroy(){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
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
                    
                    //si hay foto, que se borre tambien
                    if($socio->foto)
                        File::remove('../public/'.MEMBER_IMAGE_FOLDER.'/'.$socio->foto, true);
                        
                    Session::success("Se ha borrado el socio $socio->nombre $socio->apellidos. Estarás contento");
                    return redirect("/Socio/list");
                    
                    //si se produce unerror en la operacion con la BDD salta el catch
                }catch(SQLException $e){
                    
                    Session::error("No se pudo borrar el socio $socio->nombre $socio->apellidos");
                    
                    if(DEBUG)
                        throw new SQLException($e->getMessage());
                        
                        return redirect("/Socio/delete/$id");
                //si se produce un error al eliminar el fichero de la foto
                }catch(FileException $e){
                    Session::warning("Se elimino el libro pero no se pudo
                                        eliminar el fichero del disco");
                    
                    if(DEBUG)
                        throw new Exception($e->getMessage());
                    
                    //no podemos redirigir al libro si ya no existe
                    //volveremos al listado de libros
                    return redirect("/Libro");
                }
    }// FIN DE METODO
    
    
    //metodo DROPFOTO para borrar una foto------------------
    public function dropfoto(){
        
        //antes de nada, xa que solo lo pueda hacer el bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        //si no llega el formulario...
        if(!request()->has('borrar'))
            throw new FormException('Faltan datos para completar la operacion');
            
            //recupera el id y el socio
            $id = request()->post('id');
            $socio = Socio::findOrFail($id, "No se ha encontrado el socio");
            
            $tmp = $socio->foto; //recordaremos el nombre para poder borrarla luego
            $socio->foto = NULL; //marca la foto a NULL
            
            try{
                //primero guardamos en la bdd y luego eliminamos el fichero
                $socio->update();
                File::remove('../public/'.MEMBER_IMAGE_FOLDER.'/'.$tmp, true);
                
                Session::success("Borrado de la foto de $socio->nombre realizada");
                return redirect("/Socio/edit/$id");
                
            }catch(SQLException $e){
                Session::error("No se pudo eliminar la foto");
                
                if(DEBUG)
                    throw new SQLEXception($e->getMessage());
                    
                    return redirect("/Socio/edit/$id");
                    
            }catch(FileException $e){
                Session::warning("No se pudo eliminar el fichero del disco");
                
                if(DEBUG)
                    throw new FileException($e->getMessage());
                    
                    return redirect("Socio/edit/$socio->id");
            }
    }// FIN DROPFOTO-----------------
    
    
    
    
}//FIN DE LA CLASE