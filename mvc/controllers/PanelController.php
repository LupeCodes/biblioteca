<?php
class PanelController extends Controller{
    
    
    //metodo por defecto
    public function index(){
        //comprueba que el usuario sea bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        return view('panel/bibliotecario');
    }
    
    
    //metodo bibliotecario
    public function bibliotecario(){
        //comprueba que el usuario sea bibliotecario
        Auth::role('ROLE_LIBRARIAN');
        
        return view('panel/bibliotecario');
    }
    
    
    //metodo admin
    public function admin(){
        //comprueba que el usuario sea administrador
        Auth::role('ROLE_ADMIN');
        
        return view('panel/admin');
    }
    
}//FIN DE LA CLASE