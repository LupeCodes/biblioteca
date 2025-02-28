<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Edición de ejemplar</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="edición de ejemplar en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Editar el ejemplar') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros' => '/Libro/list',
		    $libro->titulo => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Editar ejemplar</h2>
			
			<form method="POST" action="/ejemplar/update">
			     <!-- input oculto que contiene el id del ejemplar a actualizar -->
				 <input type="hidden" name="id" value="<?= $ejemplar->id ?>">
			
				<div class="flex2">
        			<label>Año:</label>
        			<input type="text" name="anyo" value="<?= old('anyo', $ejemplar->anyo) ?>">
        			<br>
        			<label>Precio:</label>
        			<input type="number" name="precio" step="0.01" value="<?= old('precio', $ejemplar->precio) ?>">
        			<br>
        			<label>Estado:</label>
        			<input type="text" name="estado" value="<?= old('estado', $ejemplar->estado) ?>">
        			<br>
        			
        			<div class="centered mt2">
        				<input type="submit" class="button" name="actualizar" value="Actualizar">
        				<input type="reset" class="button"  value="Reset">
        			</div>
    			</div>			
			</form>
			
			
			
			<div clas="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/ejemplar/list">Lista de ejemplars</a>
				<a class="button" href="/ejemplar/show/<?= $ejemplar->id ?>">Detalles</a>
				<a class="button" href="/ejemplar/delete/<?= $ejemplar->id ?>">Borrado</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>