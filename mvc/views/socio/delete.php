<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalles de Socio</title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="detalles de socio en <?= APP_NAME ?>">
<meta name="author" content="Lupe Jiménez">

<!-- FAVICON -->
<link rel="shortcut icon" href="/favicon.ico" type="image/png">

<!-- CSS -->
<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del socio ', $socio->nombre) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Socios' => '/Socio/list',
		    'Borrar Socio' => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Borrar socio</h2>
			
			<form method="POST" class="centered m2" action="/Socio/destroy">
				<p>Confirmar el borrado del socio <b><?= $socio->nombre ?> <?= $socio->apellidos ?></b>.</p>
				
				<input type="hidden"  name="id" value="<?= $socio->id ?>">
				
				<?php 
				if (!$socio->hasAny('Prestamo')){ ?>
				    
				  <input class="button-danger" type="submit" name="borrar" value="Borrar">  
				    
				<?php } ?>
				
				
				
			</form>
			
			<div class="centered">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/socio/list">Lista de socios</a>
				<a class="button" href="/socio/show/<?= $socio->id ?>">Detalles</a>
				<a class="button" href="/socio/edit/<?= $socio->id ?>">Edición</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>