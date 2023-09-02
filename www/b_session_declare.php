<?php

if (isset($_SESSION['shynise_user_id'])) {
	// DECLARE SESSION
	$varSessionUserId = $_SESSION['shynise_user_id'];
} else {
	$varSessionUserId = 0;
}

if (isset($_SESSION['shynise_user_name'])) {
	// DECLARE SESSION
	$varSessionUserName = $_SESSION['shynise_user_name'];
} else {
	$varSessionUserName = "";
}

if (isset($_SESSION['shynise_id'])) {
	// DECLARE SESSION
	$varSessionId = true;
} else {
	$varSessionId = false;
}

?>