<?php

 require("connect_db.php");

if(isset($_GET['profesor']) && isset($_GET['archivo'])){

  $profesor = $_GET['profesor'];
  $curso = "";

  $sql2=mysqli_query($mysqli,"SELECT * FROM profesores WHERE name='$profesor'");
  if($f2=mysqli_fetch_assoc($sql2)){
    $curso = $f2['curso'];
  }

 // $archivo $_GET['archivo'];

 $fichero = "../Archivos/" . "'$curso'" . "/Alumnos/" .  $_GET['archivo'];
 $aux = file_exists($fichero);
   if( $aux ){

     header('Content-Type: application/octet-stream');
     header("Content-Transfer-Encoding: Binary");
     header("Content-disposition: attachment; filename=\"" . basename($fichero) . "\"");
     readfile($fichero); // do the double-download-dance (dirty but worky)

     // echo "<br>" . $_GET['curso'] . "<br>";
     // echo $_GET['archivo'] . "<br>";

   //echo $fichero . "<br>";

   }

   echo $aux;
   echo $fichero . "<br>";
}


 ?>
