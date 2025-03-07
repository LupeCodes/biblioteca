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
				            'Titulo' => 'titulo',
				            'Editorial' => 'editorial',
				            'Autor' => 'autor',
				            'ISBN' => 'isbn'
				        ],
				        //lista de campos para el plesplegable ordenado por 
    				    [
        				    'Titulo' => 'titulo',
        				    'Editorial' => 'editorial',
        				    'Autor' => 'autor',
        				    'ISBN' => 'isbn'
    				    ],
    				    //valor por defecto para buscar en
    				    'Título',
    				    //valor por defecto para ordenado por
    				    'Título'
				    );
				}
				?>
			
				<!-- Enlaces creados por el paginator -->
				<div class="right">
					<?= $paginator->stats() ?>
				</div>
        		<table class="table w100">
        			<tr>
        				<th>Portada</th><th>ISBN</th><th>Título</th>
        				<th>Autor</th><th>Editorial</th><th>Ejemplares</th>
        				<th class="centrado">Operaciones</th>
        			</tr>
        			<?php foreach($libros as $libro){?>
        				<tr>
        					<td class="centrado">
        						<a href='/Libro/show/<?=$libro->id?>'>
        							<img src="<?=BOOK_IMAGE_FOLDER.'/'.($libro->portada ?? DEFAULT_BOOK_IMAGE)?>"
        								class="table-image" alt="Portada de <?=$libro->titulo?>"
        								title="Portada de <?=$libro->titulo?>">
        						</a>
        					</td>
        					<td><?=$libro->isbn?></td>
        					<td><a href='/Libro/show/<?=$libro->id?>'><?=$libro->titulo?></a></td>
        					<td><?=$libro->autor?></td>
        					<td><?=$libro->editorial?></td>
        					<td><?=$libro->ejemplares?></td>
        					<td><a href='/Libro/show/<?=$libro->id?>'>Ver</a>
        						<?php if(Login::role('ROLE_LIBRARIAN')){?>
            					    <a href='/Libro/edit/<?=$libro->id?>'>Editar</a>
            					    <?php if(!$libro->ejemplares){?>
            					    <a href='/Libro/delete/<?=$libro->id?>'>Borrar</a>
            					    <?php } ?>
            					<?php } ?>		    
        					</td>
        				</tr>
        			<?php } ?>
        		</table>
        		<?= $paginator->ellipsisLinks() ?>
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