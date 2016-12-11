<?php

session_start();

	require("connect_db.php");

  if ( !isSet($_SESSION['data']) ) $_SESSION['data']=array();

  $data = json_decode(file_get_contents('php://input'), true);

	$username_pos= $data["name"];
	$pass_pos=$data['password'];

// $result = array('user' => $username_pos,
//                 'pass' =>  	$pass_pos);

$result = array('Respuesta' => false);
//la variable  $mysqli viene de connect_db que lo traigo con el require("connect_db.php");
$sql2=mysqli_query($mysqli,"SELECT * FROM profesores WHERE name='$username_pos' and pass = '$pass_pos'");
if($f2=mysqli_fetch_assoc($sql2)){
if($pass_pos==$f2['pass']){
	// $_SESSION['id']=$f2['id'];
//	$_SESSION['user']=$f2['username'];
	$result = array('Respuesta' => true);

}
}

$mysqli->close();
$result2 = json_encode($result);
echo $result2;


?>
