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
    
    
    //DETALLES DEL LIBRO---------------------------------------
    public function show(int $id = 0){
        
        //lo buscamos con findOrFail porque nos ahorra hacer más comprobaciones
        $libro = Libro::findOrFail($id);    //busca el libro con ese ID
        
        
        //carga la vista y le pasa el libro recuperado
        return view('libro/show',[
            'libro' => $libro
        ]);
    }
    
    
    //METODO CREATE-------------------------------------------
    public function create(){
        return view('libro/create');
    }
    
    
}//FIN DE LA CLASE