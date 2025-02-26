<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo socio</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="nuevo socio en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nuevo socio') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Socios' => '/Socio/list',
		    'Nuevo Socio' => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Nuevo socio</h2>
			
			<form method="POST" enctype="multipart/form-data" action="/socio/store">
			
				<div class="flex2">
        			<label>Nombre:</label>
        			<input type="text" name="nombre">
        			<br>
        			<label>Apellidos:</label>
        			<input type="text" name="apellidos">
        			<br>
        			<label>DNI:</label>
        			<input type="text" name="dni">
        			<br>
        			<label>Nacimiento:</label>
        			<input type="date" name="nacimiento">
        			<br>
        			<label>eMail:</label>
        			<input type="email"  name="email">
        			<br>
        			<label>Teléfono:</label>
        			<input type="text"  name="telefono">
        			<br>
        			<label>Dirección:</label>
        			<input type="text" name="direccion">
        			<br>
        			<label>CP:</label>
        			<input type="text" name="cp">
        			<br>
        			<label>Población:</label>
        			<input type="text" name="poblacion">
        			<br>
        			<label>Provincia:</label>
        			<input type="text" name="provincia">
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