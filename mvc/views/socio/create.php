<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Nuevo socio</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="nuevo socio en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>
		
		<!-- JS -->
		<script src="/js/Preview.js"></script>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Nuevo socio') ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Socios' => '/Socio/list',
		    'Nuevo Socio' => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			<h2>Nuevo socio</h2>
			
			<form method="POST" enctype="multipart/form-data" 
				class="flex-container gap2" action="/socio/store">
			
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
        				<input type="submit" class="button" name="guardar" value="Guardar">
        				<input type="reset" class="button"  value="Reset">
        			</div>
    			</div>
    			<figure class="flex2 centrado p2">
            		<img src="<?=MEMBER_IMAGE_FOLDER.'/'.DEFAULT_MEMBER_IMAGE?>"
            			class="cover" id="preview-image" alt="previsualizacion de la foto"
            			alt="Foto de <?=$socio->nombre?>">
            		<figcaption>Previsualización de la foto</figcaption>	
            	</figure>			
			</form>
			
			<div class="centrado my2">
				<a class="button" onclick="history.back()">Atrás</a>
				<a class="button" href="/libro/list">Lista de libros</a>
			</div>
			
		</main>
		<?= $template->footer() ?>
	</body>
</html>