<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles del tema</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="detalles del tema en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del tema ', $tema->tema) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Temas' => '/Tema/list',
		    $tema->tema => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<section>
				<h2><?= $tema->tema ?></h2>
				
				<p><b>ID:</b>			<?=$tema->id?></p>
        		<p><b>Tema:</b>			<?=$tema->tema?></p>
        		<p><b>Descripción:</b>	<?=$tema->descripcion?></p>
        		
			
			<div clas="centrado">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/tema/list">Lista de temas</a>
				<a class="button" href="/tema/edit/<?= $tema->id ?>">Editar</a>
				<a class="button" href="/tema/delete/<?= $tema->id ?>">Borrar</a>
			</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>
