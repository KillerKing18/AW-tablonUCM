<div id="cabecera">
	<h1>tablónUCM</h1>
	
	<!-- Add icon library -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<div class="icon-bar">
	  <a class="active" href="#"><i class="fa fa-home"></i></a> 
	  <a href="#"><i class="fa fa-search"></i></a> 
	  <a href="#"><i class="fa fa-envelope"></i></a> 
	  <a href="././upload.php"><i class="fa fa-globe"></i></a>
	  <a href="#"><i class="fa fa-trash"></i></a> 
	</div>
	
	<div class="saludo">
	<?php
	if (isset($_SESSION["login"]) && ($_SESSION["login"]===true)) {
		echo "Bienvenido, " . $_SESSION['nombre'] . ".<a href='logout.php'>(salir)</a>";
		
	} else {
		echo "Usuario desconocido. <a href='login.php'>Login</a> <a href='registro.php'>Registro</a>";
	}
	?>
	</div>
</div>

