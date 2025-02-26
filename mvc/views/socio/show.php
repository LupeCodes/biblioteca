<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles del socio</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="lista de libros en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del libro ', $libro->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Socios' => '/Socio/list',
		    $socio->nombre.$socio->apellidos => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<section>
				<h2><?= $socio->nombre ?> <?= $socio->apellidos ?></h2>
				
				<p><b>DNI:</b>					<?=$socio->dni?></p>
        		<p><b>Nombre:</b>				<?=$socio->nombre?></p>
        		<p><b>Apellidos:</b>			<?=$socio->apellidos?></p>
        		<p><b>eMail:</b>				<?=$socio->email?></p>
        		<p><b>Teléfono:</b>				<?=$socio->telefono?></p>
        		<p><b>Fecha de nacimiento:</b>	<?=$socio->nacimiento?></p>
        		<p><b>Direccion:</b>			<?=$socio->direccion?></p>
        		<p><b>CP:</b>					<?=$socio->cp?></p>	
        		<p><b>Población:</b>			<?=$socio->poblacion?></p>	
        		<p><b>Provincia:</b>			<?=$socio->provincia?></p>	
        		<p><b>Fecha de alta:</b>		<?=$socio->alta?></p>	
        		
			</section>
			
			
			<div clas="centrado">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/socio/list">Lista de socios</a>
				<a class="button" href="/socio/edit/<?= $socio->id ?>">Editar</a>
				<a class="button" href="/socio/delete/<?= $socio->id ?>">Borrar</a>
			</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>