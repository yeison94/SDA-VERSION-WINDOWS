<?php
$servername = "localhost";
$username = "root";
$password = "unalmedyeison94";
$dbname = "administracion";

$mysqli = new mysqli($servername, $username, $password, $dbname);

/* check connection */
if ($mysqli->connect_errno) {
    printf("Connect failed: %s\n", $mysqli->connect_error);
    exit();
}

$name_pos = "jeiso";
$curso_pos = "calculo";
$pass_pos = "23";


//Para hacer una consulta
$result=mysqli_query($mysqli,"SELECT * FROM profesores ");
if($result == false){
  while($row = mysqli_fetch_assoc($result)){
  print_r($row['name']);
  }
}


//Par eliminar

// $result = mysqli_query($mysqli, "DELETE FROM profesores WHERE name = '$name_pos' and curso = '$curso_pos'");
//
// echo $result;
//
// $mysqli->close();

?>
