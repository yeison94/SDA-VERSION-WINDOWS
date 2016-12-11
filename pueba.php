<?php
$pr = "estadisitica";
$enlace = "BackEnd/Archivos/estadisitica/Subidos/Prueba.pdf";
$enlace2 = "BackEnd/Archivos/'estadisitica'/Subidos/Prueba.pdf";
$enlace3 = "BackEnd/Archivos/" . "'$pr'" . "/Subidos/Prueba.pdf";


  //if (file_exists($enlace)) {echo "ENLACE" . "<br>";}
//  if (file_exists($enlace2)) {echo "ENLACE2" . "<br>";}
  echo $enlace3 . "<br>";




 ?>
