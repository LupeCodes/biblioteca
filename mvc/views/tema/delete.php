<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Borrar Tema</title>

<!-- META -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="borrar tema <?= APP_NAME ?>">
<meta name="author" content="Lupe Jiménez">

<!-- FAVICON -->
<link rel="shortcut icon" href="/favicon.ico" type="image/png">

<!-- CSS -->
<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Borrar tema ', $tema->tema) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Temas' => '/Tema/list',
		    'Borrar Tema' => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Borrar tema</h2>
			
			<form method="POST" class="centered m2" action="/Tema/destroy">
				<p>Confirmar el borrado del tema <b><?= $tema->tema ?></b>.</p>
				
				<input type="hidden"  name="id" value="<?= $tema->id ?>">
				
				<input class="button-danger" type="submit" name="borrar" value="Borrar">  
				    
				
				
				
				
			</form>
			
			<div class="centered">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/tema/list">Lista de temas</a>
				<a class="button" href="/tema/show/<?= $tema->id ?>">Detalles</a>
				<a class="button" href="/tema/edit/<?= $tema->id ?>">Edición</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>