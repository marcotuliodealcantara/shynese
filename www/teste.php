<?php

$host = '34.236.242.180';
$db = 'zeus';
$username = 'root';
$password = '!';
$port = '3306';


$conn = mysqli_connect($host, $username, $password, $db);

if (mysqli_connect_errno()) {
  
  die("Failed to connect to database!");

} else {

  echo "Deu certo Kondo!";

} 

?>