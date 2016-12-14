<?php

	require("connect_db.php");

//Para eliminar carpetas
function eliminarDir($carpeta){
		foreach(glob($carpeta . "/*") as $archivos_carpeta)
		{
				// echo $archivos_carpeta;

				if (is_dir($archivos_carpeta))
				{
						eliminarDir($archivos_carpeta);
				}
				else
				{
						unlink($archivos_carpeta);
				}
		}

		rmdir($carpeta);
}

if ($_SERVER['REQUEST_METHOD'] == 'GET' && empty($_GET)){

	$resultado = array();

	$result=mysqli_query($mysqli,"SELECT * FROM profesores ");
	while($row = mysqli_fetch_assoc($result)){
	  $aux = array('nombre' => $row['name'],
	                'asignatura' => $row['curso'],
								  'contra' => $row['pass']);

		$resultado[] = $aux;
	}

	$mysqli->close();

	$result2 = json_encode($resultado);
	echo $result2;

}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){

	    $data = json_decode(file_get_contents('php://input'), true);

				$operacion = $data["operacion"];
				$nameProfesor_pos= $data["nam"];
				$nameProfesor_pos = strtolower($nameProfesor_pos);
				$asignatura_pos= $data["Asignatura"];

				if($operacion == "agregar"){

					$contra_pos= $data["Contrasena"];


					// $result = array('nombre' => $nameProfesor_pos,
					//                 'asignatura' =>  	$asignatura_pos,
					// 							   'constrena' => $contra_pos);


				//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
				$retorno = mysqli_query($mysqli, "INSERT INTO profesores VALUES ('$nameProfesor_pos','$asignatura_pos', '$contra_pos')");

				if ($retorno == true){

					//	Crear las carpetas para el profesor y sus alumnos
					if (file_exists("../Archivos/'$asignatura_pos'")) {
							// echo "El fichero $nombre_fichero existe";
					} else {

								//para dar permisos a las carpetas creadas
								$oldmask = umask(0);

								mkdir("../Archivos/'$asignatura_pos'", 0777);
								chmod("../Archivos/'$asignatura_pos'", 0777);
								mkdir("../Archivos/'$asignatura_pos'/Subidos", 0777);
								chmod("../Archivos/'$asignatura_pos'/Subidos", 0777);
								mkdir("../Archivos/'$asignatura_pos'/Alumnos", 0777);
								chmod("../Archivos/'$asignatura_pos'/Alumnos", 0777);

								umask($oldmask);
					}

					$result = array('Respuesta' => true);

				}else{

					$result = array('Respuesta' => false);
				}

				$mysqli->close();


				$result2 = json_encode($result);
				echo $result2;

			}else{

				$retorno  = mysqli_query($mysqli, "DELETE FROM profesores WHERE name = '$nameProfesor_pos' and curso = '$asignatura_pos'");
				$retorno2 = mysqli_query($mysqli, "DELETE FROM archivos WHERE curso = '$asignatura_pos'");

				if($retorno == true && $retorno2 == true){

					eliminarDir("../Archivos/'$asignatura_pos'");

					$result = array('Respuesta' => true);

				}else{

					$result = array('Respuesta' => false);

				}

				$mysqli->close();


				// $result = array('nombre' => $nameProfesor_pos,
				//                 'asignatura' =>  	$asignatura_pos);


				$result2 = json_encode($result);
				echo $result2;
			}

}



?>
