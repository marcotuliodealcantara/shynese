<?php
// Always start this first
session_start();

//require("b_session.php");
require("b_session_declare.php");
require("b_connection.php");
require("b_head.php");
?>

</head>
<body class="c-layout-header-fixed c-layout-header-mobile-fixed">
		

INSERT INTO `chineasy_cards` (`id`, `id_user`, `cat`, `simp`, `trad`, `pinyin`, `pt`, `sentence`, `rightscore`, `wrongscore`) VALUES <br />

<?php
// SELECT DE RESULTADOS
$sql01 = "SELECT * FROM chineasy_cards ORDER BY cat";
$result01 = mysqli_query($conn, $sql01); 
while ($v = mysqli_fetch_array($result01, MYSQLI_ASSOC)) {


echo 
"(" .
"0, " . 
"0, " . 
$v['cat'] . ", " . 
"'" . $v['simp'] . "', " . 
"'" . $v['trad'] . "', " . 
"'" . $v['pinyin'] . "', " . 
"'" . $v['pt'] . "', " . 
"'', " . 
"0, " . 
"0)," .
"<br />";

}
?>

</body>
</html>
