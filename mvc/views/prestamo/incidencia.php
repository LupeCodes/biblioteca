<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Ampliar prestamo</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Ampliar prestamo <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Ampliar prestamo') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Panel de bibliotecario' => '/panel/bibliotecario', //para que funcione haz un panel controler con un metodo bibliotecario que te cargue esa vista
		    'Ampliar prestamo' => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Ampliar prestamo</h2>
			
			<h3>Socio: <?= $vprestamo->idsocio ?>, <?= $vprestamo->nombre ?> <?= $vprestamo->apellidos ?></h3>
			<h3>Título: <?= $vprestamo->titulo ?></h3>
			
			<form method="POST" action="/Prestamo/update">
				<input type="hidden"  name="id" value="<?= $prestamo->id ?>">
				<input type="hidden"  name="idsocio" value="<?= $prestamo->idsocio ?>">
				
				<div class="flex2">
        			
        			<label>Incidencia:</label>
        			<input type="text" name="incidencia" value="<?= old('incidencia') ?>">
        			<br>
        			
        			
        			<div class="centered mt2">
        				<input type="submit" class="button" name="actualizar" value="Actualizar">
        				<input type="reset" class="button"  value="Reset">
        			</div>
    			</div>			
			</form>
			
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/prestamo/list">Lista de prestamos</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>