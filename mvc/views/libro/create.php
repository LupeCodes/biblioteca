<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de libros</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="lista de libros en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		<!-- JS -->
		<script src="/js/Preview.js"></script>
		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del libro ', $libro->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros' => '/Libro/list',
		    'Nuevo Libro' => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Nuevo libro</h2>
			
			<form method="POST" enctype="multipart/form-data" 
				action="/libro/store" class="flex-container gap2">
			
				<div class="flex2">
        			<label>ISBN</label>
        			<input type="text" name="isbn" value="<?= old('isbn') ?>">
        			<br>
        			<label>Título</label>
        			<input type="text" name="titulo" value="<?= old('titulo') ?>">
        			<br>
        			<label>Editorial</label>
        			<input type="text" name="editorial" value="<?= old('editorial') ?>">
        			<br>
        			<label>Autor</label>
        			<input type="text" name="autor" value="<?= old('autor') ?>">
        			<br>
        			<label>Portada</label>
        			<input type="file" name="portada" accept="image/*"  id="file-with-preview">
        			<br>
        			<label>Idioma</label>
        			<select name="idioma">
        				<option value="Castellano" <?= oldSelected('idioma','Castellano') ?>>Castellano</option>
        				<option value="Catalán" <?= oldSelected('idioma','Catalán') ?>>Catalán</option>
        				<option value="Inglés" <?= oldSelected('idioma','Inglés') ?>>Inglés</option>
        				<option value="Otros" <?= oldSelected('idioma','Otros') ?>>Otros</option>
        			</select>
        			<br>
        			<label>Edición</label>
        			<input type="number" min="0" name="edicion" value="<?= old('edicion') ?>">
        			<br>
        			<label>Año</label>
        			<input type="number" name="anyo" value="<?= old('anyo') ?>">
        			<br>
        			<label>Edad Recomendada</label>
        			<input type="number" min="0" max="99" name="edadrecomendada" value="<?= old('edadrecomendada') ?>">
        			<br>
        			<label>Páginas</label>
        			<input type="number" name="paginas" value="<?= old('paginas') ?>">
        			<br>
        			<label>Características</label>
        			<input type="text" name="caracteristicas" value="<?= old('caracteristicas') ?>">
        			<br>
        			
        			<label>Tema</label>
        			<select name="idtema">
        				<?php 
        				    foreach($listaTemas as $nuevoTema)
        				        echo "<option value='$nuevoTema->id'>$nuevoTema->tema</option>";
        				?>
        			</select>
        			<p>Puedes añadir más temas posteriormente, desde la
        			operación de edición del libro.</p>
        			
        			<label>Sinopsis</label>
        			<textarea name="sinopsis"><?= old('sinopsis') ?></textarea>
        			<br>
        			
        			<div class="centered mt2">
        				<input type="submit" class="button" name="guardar" value="Guardar">
        				<input type="reset" class="button"  value="Reset">
        			</div>
    			</div>	
    			
    			<figure class="flex2 centrado p2">
            		<img src="<?=BOOK_IMAGE_FOLDER.'/'.DEFAULT_BOOK_IMAGE?>"
            			class="cover" id="preview-image" alt="previsualizacion de la portada"
            			alt="Portada del libro <?=$libro->titulo?>">
            		<figcaption>Previsualización de la portada</figcaption>	
            	</figure>
            			
			</form>
			
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/libro/list">Lista de libros</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>