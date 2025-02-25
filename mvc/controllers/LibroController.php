<?php
class LibroController extends Controller{
    
    //metodo por defecto
    public function index(){
        return $this->list();
    }
    
    
    //LISTADO DE LIBROS-----------------------------------
    public function list(){
        
        //recupera todos los libros y los ordena por id
        $libros = Libro::all(); 
        
        //para ordenarlos por titulo, por ejemplo, sería así:
        //$libros = Libro::orderBy('titulo','ASC');
        
        //carga la vista que los muestra
        return view('libro/list',[
            'libros' => $libros
        ]);
    }
}//FIN DE LA CLASE