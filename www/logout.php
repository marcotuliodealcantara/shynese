<?php
// Always start this first
session_start();

// KILL SESSION
session_destroy();

header("Location: index.php");

//require("b_head.php");
?>