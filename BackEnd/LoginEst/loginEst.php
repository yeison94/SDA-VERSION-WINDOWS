<?php

 require("connect_db.php");

 if ($_SERVER['REQUEST_METHOD'] == 'GET' && empty($_GET)){

 	$resultado = array();

 	$result=mysqli_query($mysqli,"SELECT curso FROM profesores");
 	while($row = mysqli_fetch_assoc($result)){
 	  $aux = array('asignatura' => $row['curso']);

 		$resultado[] = $aux;
 	}

 	$mysqli->close();

 	$result2 = json_encode($resultado);
 	echo $result2;

 }

 if ($_SERVER['REQUEST_METHOD'] == 'POST'){

   $operacion = "";

   foreach ($_POST as $clave=>$valor){
     if($clave == "operacion"){
        $operacion = $_POST["operacion"];
     }
   	}

    if($operacion != ""){
      if($operacion == "subirArchivo"){

        $result = array();

        $name = $_POST['name'];

        $curso =  $_POST["curse"];
       // $archivo = $data["archivo"];

        //Para subir el archivo a la carpeta
        $target_dir = "../Archivos/'$curso'/Alumnos/";

        //print_r($_FILES);
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        if(!isset($name) || $name=="undefined"){
           $name = $_FILES["file"]["name"];
        }

        if( $resulta = copy($_FILES["file"]["tmp_name"], $target_file)){

          $result[] = array('Mover_Archivo' => true);

        }else{
           $result[] = array('Mover_Archivo' => false);
        }

        $autor = "alumno";

        //Escribir el archivo en la BD
        $name_file = basename($_FILES["file"]["name"]);
        $sql3 = mysqli_query($mysqli,"INSERT INTO archivos VALUES (' $autor', '$curso','$name_file')");

        if($sql3 == true){

          $result[] = array('BD_modificada' => true);

        }else{

          $result[] = array('BD_modificada' => false);

        }

        $mysqli->close();

         $result2 = json_encode($result);
         echo $result2;
      }
    }
 }

 if ($_SERVER['REQUEST_METHOD'] == 'POST' && empty($_POST)){
    $data = json_decode(file_get_contents('php://input'), true);
  	$operacion = $data["operacion"];
    $result = array();
    if($operacion == "mostrar"){
      $curso = $data["asignatura"];
      $autor = " alumno";
      $consult=mysqli_query($mysqli,"SELECT * FROM archivos WHERE curso = '$curso' AND nombre_autor <> '$autor'");
      while($row = mysqli_fetch_assoc($consult)){
        $aux = array('nombre_archivo' => $row['nombre_archivo']);
        $result[] = $aux;
      }
    }elseif ($operacion == "descargar") {
      $curso = $data["asignatura"];
      $archivo = $data["archivo"];
      $fichero = "../Archivos/'$curso'/Subidos/" . $archivo;

      if (file_exists($fichero)) {
        header('Content-disposition: attachment; filename='.$fichero);
        header('Content-Length: ' . filesize($fichero));
        header('Content-Transfer-Encoding: binary');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        $result = readfile($fichero);
      }

    }else{
        $result[] = array('nombre_archivo' => "ERROR OBTENIENDO ARCHIVOS",
                          'operacion' => $operacion);
    }

    $result2 = json_encode($result);
    echo $result2;
}

 ?>
