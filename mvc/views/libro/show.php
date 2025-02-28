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
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del libro ', $libro->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros' => '/Libro/list',
		    $libro->titulo => null
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
        		
        		<!-- poner condicional para que no deje poner numero negativo en las paginas -->
        		<p><b>Páginas:</b>			<?=($libro->paginas>0) ? $libro->paginas : '--'?></p>
        		<p><b>Características:</b>	<?=$libro->caracteristicas ?? '--'?></p>	
			</section>
			
			<section>
				<h2>Sinopsis</h2>
				<p><?=$libro->sinopsis ? paragraph($libro->sinopsis) : 'SIN DETALLES'?></p>
			</section>
			
			<section>
				<h3>Ejemplares del libro <b><?=$libro->titulo?></b></h3>
				<table class="table w100 centered-block">
        			<tr>
        				<th>ID</th><th>Año</th><th>Precio</th><th>Estado</th><th>Operaciones</th>
        			</tr>
        			<?php foreach($ejemplares as $ejemplar){?>
        				<tr>
        					<td><?=$ejemplar->id?></td>
        					<td><?=$ejemplar->anyo?></td>
        					<td><?=$ejemplar->precio?></td>
        					<td><?=$ejemplar->estado?></td>
        					<td><a href='/Ejemplar/edit/<?=$ejemplar->id?>'>Editar</a></td>
        				</tr>
        			<?php } //mm ?>
        		</table>
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