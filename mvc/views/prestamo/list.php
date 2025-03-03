<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de prestamos</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="lista de prestamos en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de prestamos') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Panel de bibliotecario' => 'panel/bibliotecario',
		    'Prestamos' => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Lista completa de prestamos</h2>
			
			<?php if ($prestamos){ ?>
        		<table class="table w100">
        			<tr>
        				<th>ID Ejemplar:</th><th>Título</th><th>Nombre</th><th>Teléfono</th>
        					<th>Prestamo</th><th>Devolución</th><th>Operaciones</th>
        			</tr>
        			<?php foreach($prestamos as $prestamo){?>
        				<tr>
        					<td><?=$prestamo->idejemplar?></td>
        					<td><?=$prestamo->titulo?></td>
        					<td><?=$prestamo->nombre?> <?=$prestamo->apellidos?></td>
        					<td><?=$prestamo->telefono?></td>
        					<td><?=$prestamo->prestamo?></td>
        					<td><?=$prestamo->devolucion?></td>
        					<td>
        					<?php 
        					if(!$prestamo->devolucion){
        					?>
        					<a href='/Prestamo/devolucion/<?=$prestamo->id?>'>Devolución</a>
        					<a href='/Prestamo/ampliar/<?=$prestamo->id?>'>Ampliar</a>
        					
        					<?php 
        					}
        					?>
        					<a href='/Prestamo/incidencia/<?=$prestamo->id?>'>Incidencia</a>
        					</td>
        				</tr>
        			<?php } ?>
        		</table>
        	<?php }else{ ?>
        		<div class="danger p2">
        			<p>No hay prestamos que mostrar</p>
        		</div>
        	<?php } ?>
        	
        	<div class="centered">
        		<a class="button" onclick="history.back()">Atrás</a>
        	</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>