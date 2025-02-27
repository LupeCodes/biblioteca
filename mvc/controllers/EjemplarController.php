<?php
class EjemplarController extends Controller{
    
    //CREATE---------------------------------------------
    public function create(int $idlibro = 0){
        
        $libro = Libro::findOrFail($idlibro);
        
        return view('ejemplar/create',[
            'libro' => $libro
        ]);
    }
    
}//FIN DE LA CLASE