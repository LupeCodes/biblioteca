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
		<link rel="shortcut icon" href="/favicon.icon" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del libro ', $libro->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros' => '/Libro/list',
		    'Borrar Libro' => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Borrar libro</h2>
			
			<form method="POST" class="centered m2" action="/Libro/destroy">
				<p>Confirmar el borrado del libro <b><?= $libro->titulo ?></b>.</p>
				
				<input type="hidden"  name="id" value="<?= $libro->id ?>">
				<input class="button-danger" type="submit" name="borrar" value="Borrar">
			</form>
			
			<div class="centered">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/libro/list">Lista de libros</a>
				<a class="button" href="/libro/show/<?= $libro->id ?>">Detalles</a>
				<a class="button" href="/libro/edit/<?= $libro->id ?>">Edición</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>