<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo prestamo</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Nuevo prestamo <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nuevo prestamo') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Panel de bibliotecario' => '/panel/bibliotecario',
		    'Nuevo Prestamo' => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Nuevo prestamo</h2>
			
			<form method="POST" enctype="multipart/form-data" action="/Prestamo/store">
				<input type="hidden"  name="idprestamo" value="<?= $prestamo->id ?>">
				<div class="flex2">
        			<label>Socio</label>
        			<input type="number" name="idsocio" value="<?= old('socio') ?>">
        			<br>
        			<label>Ejemplar</label>
        			<input type="number" name="idejemplar" value="<?= old('ejemplar') ?>">
        			<br>
        			
        			<?php //creamos una variable para ponerle luego value al limite
		                  //provemos
		                  $tressemanas = time()+(21*24*60*60);
		                  $limi = date('Y-m-d', $tressemanas);
		                  
        			//dd($limi);
        			?>
        			
        			<label>Límite</label>
        			<input type="date" name="limite" value="<?= $limi ?>">
        			<br>
        			
        			
        			<div class="centered mt2">
        				<input type="submit" class="button" name="guardar" value="Guardar">
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