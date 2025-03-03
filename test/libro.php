<main>
	<h1>Test del modelo Libro</h1>
	
	<p>Este ejemplo también nos sirve para ver como realizar pruebas
	unitarias con las herramientas de FastLight.</p>
	
	<section id="recuperandoTemas">
		<h2>belongsToMany()</h2>
		
		<p>Recuperando los temas del libro 1.</p>
		<?php 
		  $libro = Libro::find(1);
		  dump($libro->belongsToMany('Tema', 'temas_libros'));
		?>
		
	</section>
	
	<section id="añadiendoTemas">
		<h2>addTema()</h2>
		
		<p>Añadiendo el tema 10</p>
		<?php 
		  $libro->addTema(10);
		  dump($libro->belongsToMany('Tema', 'temas_libros'));
		?>
		
	</section>
	
	<section id="eliminandoTemas">
		<h2>removeTema()</h2>
		
		<p>Eliminando el tema 10</p>
		<?php 
		  $libro->removeTema(10);
		  dump($libro->belongsToMany('Tema', 'temas_libros'));
		?>
		
	</section>

</main>
 