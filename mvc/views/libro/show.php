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
		    'Libros' => 'Libro/list',
		    $libro->titulo => 'Libro/show'
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<section>
				<h2><?= $libro->titulo ?></h2>
				
				<p><b>ISBN:</b>			<?=$libro->isbn?></p>
        		<p><b>Título:</b>		<?=$libro->titulo?></p>
        		<p><b>Autor:</b>		<?=$libro->autor?></p>
        		<p><b>Editorial:</b>	<?=$libro->editorial?></p>
        		<p><b>Idioma:</b>		<?=$libro->idioma?></p>
        		<p><b>Edición:</b>		<?=$libro->edicion?></p>
        		<p><b>Edad Recomendada:</b>
        			<?=$libro->edadrecomendada ? $libro->edadrecomendada : 'TP'?></p>
        		<p><b>Año:</b>				<?=$libro->anyo ?? '--'?></p>
        		<p><b>Páginas:</b>			<?=$libro->paginas ?? '--'?></p>
        		<p><b>Características:</b>	<?=$libro->caracteristicas ?? '--'?></p>	
			</section>
			
			<section>
				<h2>Sinopsis</h2>
				<p><?=$libro->sinopsis ? paragraph($libro->sinopsis) : 'SIN DETALLES'?></p>
			</section>
			
			<div clas="centrado">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/libro/list">Lista de libros</a>
				<a class="button" href="/libro/edit/<?= $libro->id ?>">Editar</a>
				<a class="button" href="/libro/delete/<?= $libro->id ?>">Borrar</a>
			</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>