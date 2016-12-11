<?php

if(isset($_GET['curso']) && isset($_GET['archivo'])){

  $curso = $_GET['curso'];
 // $archivo $_GET['archivo'];

 $fichero = "../Archivos/" . "'$curso'" . "/Subidos/" .  $_GET['archivo'];
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
