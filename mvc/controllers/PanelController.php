<?php
class PanelController extends Controller{
    
    
    //metodo por defecto
    public function index(){
        return view('panel/bibliotecario');
    }
    
    
    //metodo por defecto
    public function bibliotecario(){
        return view('panel/bibliotecario');
    }
    
}//FIN DE LA CLASE