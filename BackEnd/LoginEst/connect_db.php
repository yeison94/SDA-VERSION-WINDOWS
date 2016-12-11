<?php
//Archivo para entrablar la conexion

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "administracion";

		$mysqli = new MySQLi($servername, $username, $password, $dbname);
		if ($mysqli -> connect_errno) {
			die( "Fallo la conexión a MySQL: (" . $mysqli -> mysqli_connect_errno()
				. ") " . $mysqli -> mysqli_connect_error());
		}
		else
			//echo "Conexión exitossa!";

?>
