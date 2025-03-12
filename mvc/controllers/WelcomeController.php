<?php

/** Welcome
 *
 * Controlador por defecto, según la configuración de config.php
 *
 * Última revisión: 09/01/2025
 * 
 * @author Robert Sallent <robertsallent@gmail.com>
 */

class WelcomeController extends Controller{
    
    /** Carga la vista de portada. */
    public function index():Response{
        
        //recuperamos los ultimos 5 libros, para poder poner las "novedades" en la portada
        $libros = Libro::orderBy('id','desc', 5);
        
        return view('welcome', [
            'libros' => $libros
        ]);
    }  
}

