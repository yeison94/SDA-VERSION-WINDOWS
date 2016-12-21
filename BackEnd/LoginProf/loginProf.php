<?php

 require("connect_db.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    $curso = "";

  	$operacion = $_POST["operacion"];

    $nombre_profesor_logeado = $_POST['curse'];

    //Obtener el curso del profesor dado el nombre de este
   $sql2=mysqli_query($mysqli,"SELECT * FROM profesores WHERE name='$nombre_profesor_logeado'");
   if($f2=mysqli_fetch_assoc($sql2)){
     $curso = $f2['curso'];
   }

    if($operacion == "subirArchivo"){

      $name = $_POST['name'];

      $result = array();

     //Para subir el archivo a la carpeta
     $target_dir = "../Archivos/'$curso'/Subidos/";

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

      //Escribir el archivo en la BD
      $name_file = basename($_FILES["file"]["name"]);
      $sql3 = mysqli_query($mysqli,"INSERT INTO archivos VALUES ('$nombre_profesor_logeado', '$curso','$name_file')");

      if($sql3 == true){

        $result[] = array('BD_modificada' => true);

      }else{

        $result[] = array('BD_modificada' => false);

      }

      $mysqli->close();

    }

    if($operacion == "obtener_archivos"){

      $result = array();

      $consult=mysqli_query($mysqli,"SELECT * FROM archivos WHERE nombre_autor = '$nombre_profesor_logeado' AND curso = '$curso'");
      while($row = mysqli_fetch_assoc($consult)){
        $aux = array('nombre_autor' => $row['nombre_autor'],
                      'curso' => $row['curso'],
                      'nombre_archivo' => $row['nombre_archivo']);

        $result[] = $aux;
      }

    }

    if($operacion == "obtener_archivos_alumnos"){
      $result = array();
      $consult=mysqli_query($mysqli,"SELECT * FROM archivos WHERE nombre_autor <> '$nombre_profesor_logeado' AND curso = '$curso'");
      while($row = mysqli_fetch_assoc($consult)){
        $aux = array('nombre_autor' => $row['nombre_autor'],
                      'curso' => $row['curso'],
                      'nombre_archivo' => $row['nombre_archivo']);

        $result[] = $aux;
      }
      // $result[] = array('curso' => $curso,
      //                   'Profesor' =>   $nombre_profesor_logeado);
    }
}

 $result2 = json_encode($result);
 echo $result2;
?>
