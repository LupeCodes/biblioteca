<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Editar tema</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="editar tema en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Editar el tema ', $tema->tema) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Temas' => '/Tema/list',
		    $tema->tema => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Editar tema</h2>
			
			<form method="POST" action="/tema/update">
			     <!-- input oculto que contiene el id del tema a actualizar -->
				 <input type="hidden" name="id" value="<?= $tema->id ?>">
			
				<div class="flex2">
        			<label>Tema:</label>
        			<input type="text" name="tema" value="<?= old('tema', $tema->tema) ?>">
        			<br>
        			<label>Descripción:</label>
        			<input type="text" name="descripcion" value="<?= old('descripcion', $tema->descripcion) ?>">
        			<br>
        			
        			
        			<div class="centered mt2">
        				<input type="submit" class="button" name="actualizar" value="Actualizar">
        				<input type="reset" class="button"  value="Reset">
        			</div>
    			</div>			
			</form>
			
			<div clas="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/tema/list">Lista de temas</a>
				<a class="button" href="/tema/show/<?= $tema->id ?>">Detalles</a>
				<a class="button" href="/tema/delete/<?= $tema->id ?>">Borrado</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>