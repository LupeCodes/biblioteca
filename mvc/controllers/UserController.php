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
    
}// FIN DE CLASE