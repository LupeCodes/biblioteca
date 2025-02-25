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
		<?= $template->header('Lista de libros') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros' => 'Libro/list'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Lista completa de libros</h2>
			
			<?php if ($libros){ ?>
        		<table class="table w100">
        			<tr>
        				<th>ISBN</th><th>Título</th><th>Autor</th><th>Editorial</th><th>Operaciones</th>
        			</tr>
        			<?php foreach($libros as $libro){?>
        				<tr>
        					<td><?=$libro->isbn?></td>
        					<td><a href='/Libro/show/<?=$libro->id?>'><?=$libro->titulo?></a></td>
        					<td><?=$libro->autor?></td>
        					<td><?=$libro->editorial?></td>
        					<td><a href='/Libro/show/<?=$libro->id?>'>Ver</a>
        					    <a href='/Libro/edit/<?=$libro->id?>'>Editar</a>
        					    <a href='/Libro/delete/<?=$libro->id?>'>Borrar</a>
        					</td>
        				</tr>
        			<?php } ?>
        		</table>
        	<?php }else{ ?>
        		<div class="danger p2">
        			<p>No hay libros que mostrar</p>
        		</div>
        	<?php } ?>
        	
        	<div class="centered">
        		<a class="button" onclick="history.back()">Atrás</a>
        	</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>