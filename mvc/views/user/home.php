<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="UTF-8">
		<title>Detalles del socio</title>
		
		<!-- META -->
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="lista de libros en <?= APP_NAME ?>">
		<meta name="author" content="Lupe Jiménez">
		
		<!-- FAVICON -->
		<link rel="shortcut icon" href="/favicon.ico" type="image/png">
		
		<!-- CSS -->
		<?= $template->css() ?>
		
		<!-- JS -->
		<script src="/js/BigPicture.js"></script>

		
	</head>
	<body>
		<?= $template->login() ?>
		<?= $template->header('Detalles del libro ', $libro->titulo) ?>
		<?= $template->menu() ?>
		<?= $template->breadCrumbs([
		    'Socios' => '/Socio/list',
		    $socio->nombre.' '.$socio->apellidos => null
		    //'Detalles del libro' => 'Libro/show'
		]) ?>
		<?= $template->messages() ?>
		
		<main>
			<h1><?= APP_NAME ?></h1>
			
			<section class="flex-container" id="user-data">
				<div class="flex2">
					<h2><?= "Home de $user->displanyname" ?></h2>
					
					<p><b>Nombre:</b>				<?= $user->displayname ?></p>
					<p><b>Email:</b>				<?= $user->email ?></p>
					<p><b>Teléfono:</b>				<?= $user->phone ?></p>
					<p><b>Fecha de alta:</b>		<?= $user->created_at ?></p>
					<p><b>Última modificación:</b>	<?= $user->updated_at ?? '--' ?></p>
				
				</div>
				<!-- Esta parte solo si creamos la carpeta para las fotos de perfil -->
				<figure class="flex1 centrado">
					<img src="<?= USER_IMAGE_FOLDER.'/'.($user->picture ?? DEFAULT_USER_IMAGE) ?>"
						class="cover enlarge-image" alt="Imagen de perfil <?= $user->displayname ?>">
					<figcaption>Imagen de perfil de <?= $user->displayname ?></figcaption>	
				</figure>
			</section>
		</main>
		<?= $template->footer() ?>
	</body>
</html>
