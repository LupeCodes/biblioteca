<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Editar socio</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="editar socio en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>
		
		<!-- JS -->
		<script src="/js/BigPicture.js"></script>
		<script src="/js/Preview.js"></script>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Editar el libro ', $libro->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Socios' => '/Socio/list',
		    $socio->nombre.$socio->apellido => null
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Editar socio</h2>
			
			<section class="flex-container gap2">
    			<form method="POST" action="/socio/update" enctype="multipart/form-data"
    					class="flex2 no-border no-shadow">
    			     <!-- input oculto que contiene el id del socio a actualizar -->
    				 <input type="hidden" name="id" value="<?= $socio->id ?>">
    			
    				<div class="flex2">
            			<label>Nombre:</label>
            			<input type="text" name="nombre" value="<?= old('nombre', $socio->nombre) ?>">
            			<br>
            			<label>Apellidos:</label>
            			<input type="text" name="apellidos" value="<?= old('apellidos', $socio->apellidos) ?>">
            			<br>
            			<label>DNI:</label>
            			<input type="text" name="dni" value="<?= old('dni', $socio->dni) ?>">
            			<br>
            			<label>Foto</label>
        				<input type="file" name="foto" accept="image/*" id="file-with-preview">
        				<br>
            			<label>Nacimiento:</label>
            			<input type="date" name="nacimiento" value="<?= old('nacimiento', $socio->nacimiento) ?>">
            			<br>
            			<label>eMail:</label>
            			<input type="email"  name="email" value="<?= old('email', $socio->email) ?>">
            			<br>
            			<label>Teléfono:</label>
            			<input type="text"  name="telefono" value="<?= old('telefono', $socio->telefono) ?>">
            			<br>
            			<label>Dirección:</label>
            			<input type="text" name="direccion" value="<?= old('direccion', $socio->direccion) ?>">
            			<br>
            			<label>CP:</label>
            			<input type="text" name="cp" value="<?= old('cp', $socio->cp) ?>">
            			<br>
            			<label>Población:</label>
            			<input type="text" name="poblacion" value="<?= old('poblacion', $socio->poblacion) ?>">
            			<br>
            			<label>Provincia:</label>
            			<input type="text" name="provincia" value="<?= old('provincia', $socio->provincia) ?>">
            			<br>
            			
            			<div class="centered mt2">
            				<input type="submit" class="button" name="actualizar" value="Actualizar">
            				<input type="reset" class="button"  value="Reset">
            			</div>
        			</div>			
				</form>
				<figure class="flex1 centrado p2">
            		<img src="<?=MEMBER_IMAGE_FOLDER.'/'.($socio->foto ?? DEFAULT_MEMBER_IMAGE)?>"
            			class="cover" id="preview-image" alt="previsualizacion de la foto"
            			alt="Foto de <?=$socio->nombre?>">
            		<figcaption>Previsualización de la foto</figcaption>
            		
            		<!-- Boton para eliminar la portada (sin cambiar nada más) -->
					<?php if($socio->foto){?>
					<form method="POST" action="/socio/dropfoto" class="no-border no-shadow">
						<input type="hidden" name="id" value="<?=$socio->id?>">
						<input type="submit" class="button-danger"
							name="borrar" value="Eliminar foto">
					</form>
					<?php } ?>	
            	</figure>	
			</section>
			
			<div clas="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/socio/list">Lista de socios</a>
				<a class="button" href="/socio/show/<?= $socio->id ?>">Detalles</a>
				<a class="button" href="/socio/delete/<?= $socio->id ?>">Borrado</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>