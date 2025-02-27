<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Crear ejemplar</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Crear ejemplar <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Crear un nuevo ejemplar de ', $libro->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros' => '/Libro/list',
		    'Nuevo Ejemplar' => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Nuevo ejemplar de <?= $libro->titulo ?></h2>
			
			<form method="POST" enctype="multipart/form-data" action="/Ejemplar/store">
				<input type="hidden"  name="idlibro" value="<?= $libro->id ?>">
				<div class="flex2">
        			<label>Año</label>
        			<input type="text" name="anyo" value="<?= old('anyo') ?>">
        			<br>
        			<label>Precio</label>
        			<input type="number" name="precio" step="0.01" value="<?= old('precio') ?>">
        			<br>
        			<label>Estado</label>
        			<input type="text" name="estado" value="<?= old('estado') ?>">
        			<br>
        			
        			
        			<div class="centered mt2">
        				<input type="submit" class="button" name="guardar" value="Guardar">
        				<input type="reset" class="button"  value="Reset">
        			</div>
    			</div>			
			</form>
			
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/libro/list">Lista de libros</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>