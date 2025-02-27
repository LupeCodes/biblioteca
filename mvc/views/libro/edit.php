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
		<?= $template->header('Editar el libro ', $libro->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Libros' => '/Libro/list',
		    $libro->titulo => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Editar libro</h2>
			
			<form method="POST" action="/libro/update">
			     <!-- input oculto que contiene el id del libro a actualizar -->
				 <input type="hidden" name="id" value="<?= $libro->id ?>">
			
				<div class="flex2">
        			<label>ISBN</label>
        			<input type="text" name="isbn" value="<?= old('isbn', $libro->isbn) ?>">
        			<br>
        			<label>Título</label>
        			<input type="text" name="titulo" value="<?= old('titulo', $libro->titulo) ?>">
        			<br>
        			<label>Editorial</label>
        			<input type="text" name="editorial" value="<?= old('editorial', $libro->editorial) ?>">
        			<br>
        			<label>Autor</label>
        			<input type="text" name="autor" value="<?= old('autor'), $libro->autor ?>">
        			<br>
        			<label>Idioma</label>
        			<select name="idioma">
        				<option value="Castellano" <?=$libro->idioma=='Castellano'? 'selected':''?>>
        					Castellano</option>
        				<option value="Catalán" <?=$libro->idioma=='Catalán'? 'selected':''?>>
        					Catalán</option>
        				<option value="Inglés" <?=$libro->idioma=='Inglés'? 'selected':''?>>
        					Inglés</option>	
        				<option value="Otros" <?=$libro->idioma=='Otros'? 'selected':''?>>
        					Otros</option>
        			</select>
        			<br>
        			<label>Edición</label>
        			<input type="number" min="0" name="edicion" value="<?= old('edicion', $libro->edicion) ?>">
        			<br>
        			<label>Año</label>
        			<input type="number" name="anyo" value="<?= old('anyo', $libro->anyo) ?>">
        			<br>
        			<label>Edad Recomendada</label>
        			<input type="number" min="0" max="99" name="edadrecomendada" value="<?= old('edadrecomendada', $libro->edadrecomendada) ?>">
        			<br>
        			<label>Páginas</label>
        			<input type="number" name="paginas" value="<?= old('paginas', $libro->paginas) ?>">
        			<br>
        			<label>Características</label>
        			<input type="text" name="caracteristicas" value="<?= old('caracteristicas', $libro->caracteristicas) ?>">
        			<br>
        			<label>Sinopsis</label>
        			<textarea name="sinopsis"><?= old('sinopsis'), $libro->sinopsis ?></textarea>
        			<br>
        			
        			<div class="centered mt2">
        				<input type="submit" class="button" name="actualizar" value="Actualizar">
        				<input type="reset" class="button"  value="Reset">
        			</div>
    			</div>			
			</form>
			
			<section>
				<script>
					function confirmar(id){
						if(confirm('¿Seguro que deseas eliminar?'))
							location.href = '/Ejemplar/destroy/'+id
					}
				</script>
			
				<h3>Ejemplares del libro <b><?=$libro->titulo?></b></h3>
				<a class="button" href="/Ejemplar/create/<?= $libro->id ?>">
        			Nuevo Ejemplar
        		</a>
        		
        		<?php 
        		  if(!$ejemplares){
        		    echo "<div class='warning p2'><p>No hay ejemplares de este libro.</p></div>";
        		  }else{
        		?>
        		
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
        					
        					<td class="centered">
        					<?php if(!$ejemplar->hasAny('Prestamo')) { ?>
        						<a onclick="confirmar(<?= $ejemplar->id ?>)">Borrar</a>
        					<?php }  ?>
        					</td>
        				</tr>
        			<?php } //mm ?>
        		</table>
        		<?php }  ?>
			</section>
			
			<div clas="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/libro/list">Lista de libros</a>
				<a class="button" href="/libro/show/<?= $libro->id ?>">Detalles</a>
				<a class="button" href="/libro/delete/<?= $libro->id ?>">Borrado</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>