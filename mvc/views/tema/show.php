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
        		
			<?php 
				if(!$libros){
				    echo "<div class='warning p2'><p>No hay libros que traten de este tema</p></div>";
				}else{?>
				<h2>Libros que tratan sobre <?= $tema->tema ?></h2>
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
        						<?php if(Login::role('ROLE_LIBRARIAN')){?>
            					    <a href='/Libro/edit/<?=$libro->id?>'>Editar</a>
            					    <a href='/Libro/delete/<?=$libro->id?>'>Borrar</a>
            					<?php } ?>
        					</td>
        				</tr>
        			<?php } ?>
        		</table>
        		<?php } ?>
			
			<div clas="centrado">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/tema/list">Lista de temas</a>
				<?php if(Login::role('ROLE_LIBRARIAN')){?>
    				<a class="button" href="/tema/edit/<?= $tema->id ?>">Editar</a>
    				<a class="button" href="/tema/delete/<?= $tema->id ?>">Borrar</a>
				<?php } ?>
			</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>
