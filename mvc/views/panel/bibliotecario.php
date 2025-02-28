<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Panel del bibliotecario</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Panel del bibliotecario en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Panel del bibliotecario') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Panel del bibliotecario' => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<div class="flex-container space-around">
				<section>
					<h2>Operaciones con libros</h2>
					<ul>
    					<li><a href='/Libro'>Lista de Libros</a></li>
    					<li><a href='/Libro/create'>Nuevo Libro</a></li>
					</ul>
				</section>
				<section>
					<h2>Operaciones con socios</h2>
					<ul>
    					<li><a href='/Socio'>Lista de Socios</a></li>
    					<li><a href='/Socio/create'>Nuevo Socio</a></li>
					</ul>
				</section>
				<section>
					<h2>Operaciones con temas</h2>
					<ul>
    					<li><a href='/Tema'>Lista de Temas</a></li>
    					<li><a href='/Tema/create'>Nuevo Tema</a></li>
					</ul>
				</section>
				<section>
					<h2>Operaciones con prestamos</h2>
					<ul>
    					<li><a href='/Prestamo'>Lista de Prestamos</a></li>
    					<li><a href='/Prestamo/create'>Nuevo Prestamo</a></li>
					</ul>
				</section>
			</div>
        	
        	<div class="centered">
        		<a class="button" onclick="history.back()">Atrás</a>
        	</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>