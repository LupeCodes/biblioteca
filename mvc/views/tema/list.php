<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de temas</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="lista de temas en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de temas') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Temas' => 'Tema/list'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Lista completa de temas</h2>
			
			<?php if ($temas){ ?>
			<!-- FILTRO DE BUSQUEDA -->
				<?php 
				//si hay filtro guardado en sesion...
				if($filtro){
				    //pone el formulario de "quitar filtro"
				    //el metodo removeFilterForm necesita conocer el filtro
				    //y la ruta a la q se envia el formulario
				    echo $template->removeFilterForm($filtro, '/Tema/list');
				//y si no hay filtro guardado en sesion...    
				}else{
				    //pone el formulario de nuevo filtro
				    echo $template->filterForm(
				    
				        //lista de campos para el desplegable buscar en
				         [
				            'ID' => 'id',
				            'Tema' => 'tema',
				            'Descripción' => 'descripcion'
				        ],
				        //lista de campos para el plesplegable ordenado por 
    				    [
        				    'ID' => 'id',
        				    'Tema' => 'tema',
        				    'Descripción' => 'descripcion'
    				    ],
    				    //valor por defecto para buscar en
    				    'Tema',
    				    //valor por defecto para ordenado por
    				    'Tema'
				    );
				}
				?>
				
				<!-- Enlaces creados por el paginator -->
				<div class="right">
					<?= $paginator->stats() ?>
				</div>
				
        		<table class="table w100">
        			<tr>
        				<th>ID</th><th>Tema</th><th>Descripcion</th><th>Operaciones</th>
        			</tr>
        			<?php foreach($temas as $tema){?>
        				<tr>
        					<td><?=$tema->id?></td>
        					<td><a href='/Tema/show/<?=$tema->id?>'><?=$tema->tema?></a></td>
        					<td><?=$tema->descripcion?></td>
        					<td><a href='/Tema/show/<?=$tema->id?>'>Ver</a>
        					    <a href='/Tema/edit/<?=$tema->id?>'>Editar</a>
        					    <a href='/Tema/delete/<?=$tema->id?>'>Borrar</a>
        					</td>
        				</tr>
        			<?php } ?>
        		</table>
        		<?= $paginator->ellipsisLinks() ?>
        	<?php }else{ ?>
        		<div class="danger p2">
        			<p>No hay temas que mostrar</p>
        		</div>
        	<?php } ?>
        	
        	<div class="centered">
        		<a class="button" onclick="history.back()">Atrás</a>
        	</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>