<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Panel del administrador</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="Panel del administrador en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Panel del administrador') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Panel del administrador' => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1>Panel del administrador</h1>
			
			<p>Aquí encontrarás los enlaces a las distintas operaciones
			para el administrador de la aplicacion "BiblioLupe".</p>
			
			<div class="flex-container gap2">
				<section class="flex1">
					<h2>Operaciones con usuarios</h2>
					<ul>
						<li><a href='/User/list'>Lista de usuarios</a></li>
						<li><a href='/User/create'>Nuevo usuario</a></li>
					</ul>
				</section>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>