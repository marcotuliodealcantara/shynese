<?php
require("b_connection.php");

// SELECT DE RESULTADOS
$sql = "UPDATE chineasy_cards SET rightscore = rightscore + '1' WHERE id = '".$_GET['c']."' LIMIT 1";

if ($result = mysqli_query($conn, $sql)) {
	echo "Success";

} else {
	echo "Error";
}
?>