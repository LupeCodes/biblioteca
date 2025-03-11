<?php
class UserController extends Controller{
    
    //FUNCION HOME------------------------
    public function home(){
        
        Auth::check(); //solo usuarios identificados
        //carga la vista home y le pasa el usuario identificado
        //el usuario se puede recuperar con el metodo Login::user()
        return view('user/home',[
            'user' => Login::user()
        ]);
        
    }//FIN HOME--------------------------------
    
    
    //FUNCION CREATE-------------------------------
    function create(){
        //operacion solo para el administrador
        //equivale a Auth::role('ROLE_ADMIN') pero es mas corto
        Auth::admin();
        
        return view('user/create');
    }// FIN CREATE
    
    
    //FUNCION STORE------------------------------------
    public function store(){
        //Esta operacion solo la puede hacer el administrador
        Auth::admin();
        
        //comprueba que llega el formulario
        if(!request()->has('guardar'))
            throw new FormException('No se recibió el formulario');
        
        $user = new User(); //crea el nuevo usuario
        
        //recupera el password y lo encripta
        //en este caso no lo cogemos de la request, xq el saneamiento
        //podria provocar que el password cambiara
        //(y el usuario no podría hacer login)
        //no es peligroso porque al encriptarlo no afectaran los caracteres especiales
        $user->password = md5($_POST['password']);
        $repeat         = md5($_POST['repeatpassword']);
        
        //comprueba que los dos password coinciden
        if($user->password != $repeat)
            throw new ValidationException("Las claves no coinciden.");
        
        //toma el resto de los valores del formulario
        $user->displayname   = request()->post('displayname');
        $user->email         = request()->post('email');
        $user->phone         = request()->post('phone');
        
        //añade ROLE_USER y el rol que venga del formulario, no pasa nada si 
        //se repite "ROLE_USER", el metodo addRole() elimina las repeticiones.
        $user->addRole('ROLE_USER', $this->request->post('roles'));
        
        try{
            $user->save();      //guarda el usuario
            
            $file = request()->file(    //recupera la foto
                    'picture',      //nombre del input
                    8000000,        //tamaño máximo del fichero
                    ['image/png', 'image/jpeg', 'image/gif'] //tipos aceptados
                
                );
            //si hay fichero lo guardamos y actualizamos el campo picture
            if($file){
                $user->picture = $file->store('../public/'.USER_IMAGE_FOLDER,'user_');
                $user->update(); //actualiza el usuario en la bdd para añadir la foto
            }
            
            Session::success("Nuevo usuario $user->displayname creado con exito");
            return redirect("/Panel/admin");
            
        //si se produce un error de validacion     
        }catch(ValidationException $e){
            
            Session::error($e->getMessage());
            return redirect("/User/create");
            
        //si se produce un error al guardar en la BDD     
        }catch(SQLException $e){
            Session::error("Se produjo un error al guardar el usuario $user->displayname");
            
            if(DEBUG)
                throw new Exception($e->getMessage());
            
            return redirect("/User/create");
            
        //si se produce un error en la subida del fichero
        }catch(UploadException $e){
            Session::warning("El usuario se guardó correctamente,
                                pero no se pudo subir el fichero de imagen");
            
            if(DEBUG)
                throw new Exception($e->getMessage());
            
            //redirecciona a la edición de usuario(ver ejercicios)
            return redirect("/User/edit/$user->id");
        }
        
    }// FIN DE STORE
    
    //FUNCTION LIST-----------------------------------------------------------------------
    public function list(){
        //antes de nada, xa que solo lo pueda hacer el admin
        Auth::role('ROLE_ADMIN');
        
        //de momento sin paginacion ni filtros, ya lo añadimos luego
        $users = User::all();
        
        return view('user/list', [
            'users' => $users
        ]);
    }//FIN LIST
    
    //PARA VER LOS DETALLES DEL USUARIO
    public function show(int $id = 0){
        //antes de nada, xa que solo lo pueda hacer el admin
        Auth::role('ROLE_ADMIN');
        
        $user = User::findOrFail($id, "No se encontró el usuario");
        
        return view('user/show', [
            'user' => $user
        ]);
    }//FIN DE SHOW
    
    
    
    //EDIT, MANDAR A LA VISTA-----------------------------------------
    public function edit(int $id = 0){
        
        Auth::role('ROLE_ADMIN');
        
        $user = User::findOrFail($id, "No se encontró el usuario");
        
        return view('user/edit', [
            'user' => $user
        ]);
    }
    
    
    //FALTA LA FUNCTION UPDATE----------------------------------------
    //TODO FUNCTION UPDATE
    
    
    //TODO addRole-----------------------------------------------------
    
    //TODO removeRole--------------------------------------------------
    
}// FIN DE CLASE