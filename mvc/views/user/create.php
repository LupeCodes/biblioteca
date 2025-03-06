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
			
			<section id="new-user">
    			<h2>Nuevo usuario</h2>
    			
    			<div class="flex-container">
    				<form method="POST" enctype="multipart/form-data" 
    					class="flex2 no-border" action="/User/store">
    					
    					<label>Nombre</label>
    					<input type="text" name="displayname">
    					<br>
    					<label>Email</label>
    					<input type="email" name="email" id="inputEmail">
    					<span id="comprobacion" class='info'></span>
    					<br>
    					<label>Telefono</label>
    					<input type="text" name="phone">
    					<br>
    					<label>Password</label>
    					<input type="password" name="password">
    					<br>
    					<label>Repite Password</label>
    					<input type="password" name="repeatpassword">
    					<br>
    					<label>Imagen de perfil</label>
    					<input type="file" name="picture" accept="image/*"
    							id="file-with-preview">
    					<br>
    					
    					<label>Rol</label>
    					<!-- 
    					   Este desplegable se genera a partir de la lista de
    					   roles indicados en el fichero config.php
    					   Añadid a esa lista el rol: 'Bibliotecario' => 'ROLE_LIBRARIAN'
    					 -->
    					 <select name="roles">
    					 	<?php foreach(USER_ROLES as $roleName => $roleValue){?>
    					 		<option value="<?= $roleValue ?>"><?= $roleName ?></option>
    					 	<?php } ?>	
    					 </select>
    					 
    					 <div class="centered mt3">
    					 	<input type="submit" class="button" name="guardar" value="Guardar">
    					 	<input type="reset" class="button" value="Reset">
    					 </div>
    				</form>
    				
    				<figure class="flex1 centrado">
    					<img src="<?= USER_IMAGE_FOLDER.'/'.DEFAULT_USER_IMAGE ?>" id="preview-image"
    							class="cover" alt="Previsualizacion de la imagen de perfil">
    				</figure>
    				
    			</div>
    				
    				
    			
		
			</section>	
		</main>
		<?= $template->footer() ?>
	</body>
</html>