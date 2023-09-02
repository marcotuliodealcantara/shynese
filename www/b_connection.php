<?php


$host = 'localhost';
$db = 'chineasy2';
$username = 'root';
$password = 'root1';
$port = '8889';


/*
$host = '35.245.146.110';
$db = 'chineasy';
$username = 'root';
$password = '';
$port = '3306';
*/

/*
$host = '50.116.87.140';
$db = 'shynes05_shynese';
$username = 'shynes05_marco';
$password = '';
//$port = '3306';
*/

$conn = mysqli_connect($host, $username, $password, $db);

if (mysqli_connect_errno()) {
  
  die("Failed to connect to database!");

} 

// CONSTANTES
//$url_uploaded_files = "images/uploaded_files/";
?>