<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Lista de socios</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="lista de socios en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Lista de socios') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Socios' => 'Socio/list'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Lista completa de socios</h2>
			
			<?php if ($socios){ ?>
			<!-- FILTRO DE BUSQUEDA -->
				<?php 
				//si hay filtro guardado en sesion...
				if($filtro){
				    //pone el formulario de "quitar filtro"
				    //el metodo removeFilterForm necesita conocer el filtro
				    //y la ruta a la q se envia el formulario
				    echo $template->removeFilterForm($filtro, '/Libro/list');
				//y si no hay filtro guardado en sesion...    
				}else{
				    //pone el formulario de nuevo filtro
				    echo $template->filterForm(
				    
				        //lista de campos para el desplegable buscar en
				         [
				            'Nombre' => 'nombre',
				            'DNI' => 'dni',
				            'Telefono' => 'telefono',
				            'eMail' => 'email'
				        ],
				        //lista de campos para el plesplegable ordenado por 
    				    [
        				    'Nombre' => 'nombre',
        				    'DNI' => 'dni',
        				    'Telefono' => 'telefono',
        				    'eMail' => 'email'
    				    ],
    				    //valor por defecto para buscar en
    				    'Nombre',
    				    //valor por defecto para ordenado por
    				    'Nombre'
				    );
				}
				?>
				<!-- Enlaces creados por el paginator -->
				<div class="right">
					<?= $paginator->stats() ?>
				</div>
				
        		<table class="table w100">
        			<tr>
        				<th>ID</th><th>Nombre</th><th>Apellidos</th><th>DNI</th><th>eMail</th><th>Teléfono</th><th>Operaciones</th>
        			</tr>
        			<?php foreach($socios as $socio){?>
        				<tr>
        					<td><?=$socio->id?></td>
        					<td><a href='/Socio/show/<?=$socio->id?>'><?=$socio->nombre?></a></td>
        					<td><?=$socio->apellidos?></td>
        					<td><?=$socio->dni?></td>
        					<td><?=$socio->email?></td>
        					<td><?=$socio->telefono?></td>
        					<td><a href='/Socio/show/<?=$socio->id?>'>Ver</a>
        					    <a href='/Socio/edit/<?=$socio->id?>'>Editar</a>
        					    <a href='/Socio/delete/<?=$socio->id?>'>Borrar</a>
        					</td>
        				</tr>
        			<?php } ?>
        		</table>
        		<?= $paginator->ellipsisLinks() ?>
        	<?php }else{ ?>
        		<div class="danger p2">
        			<p>No hay socios que mostrar</p>
        		</div>
        	<?php } ?>
        	
        	<div class="centered">
        		<a class="button" onclick="history.back()">Atrás</a>
        	</div>
		</main>
		<?= $template->footer() ?>
	</body>
</html>