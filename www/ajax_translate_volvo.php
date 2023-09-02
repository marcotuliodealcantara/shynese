<?php
include("../vendor/autoload.php");
use Google\Cloud\Translate\V2\TranslateClient;
$translate = new TranslateClient([

    'key' => "AIzaSyDlClu_-KwftXmgG4DYlvLXEHoNAEIJZRo"

]);
?>


<html>
<head>



</head>

<body style="margin: 40px;">

	<script type="text/javascript">
	  function copiarTexto() {
	    var textoCopiado = document.getElementById("contentFinal").text();
	    textoCopiado.select();
	    document.execCommand("Copy");	
	    alert("Texto Copiado: " + textoCopiado.value);
	  }
	</script>

	<div style="float: left; width: 48%; border: solid 0px;">
		<form method="post" action="">
		<input type="hidden" name="processa" value="1" />
		<textarea name="conteudo" id="conteudo" rows="30" cols="60"></textarea> <br /><br />
		<input type="submit" style="padding: 18px; width: 400px;" name="Enviar" />
		</form>
	</div>

	<div style="float: right; width: 48%; border: solid 0px;">
	

<?php

if ($_POST['processa'] == "1") {

	$w2t = $_POST['conteudo'];

	$content = explode(",",  $w2t);

	foreach ($content as $key => $value) {
	 	
		$insideContent = explode (":", $value);

		$control = 0;

		foreach ($insideContent as $insideValue) {

			if ($control == 0) {

				echo $insideValue . ": \"";
				$control = 1;


			} else {

				$insideValueClear = str_replace('"', '', $insideValue);

				$result = $translate->translate($insideValueClear, [
			    	'target' => 'en'
				]);

				echo $result['text'] . "\",<br />";		

				$control = 0;

			}	

		}

	} 

}

?>
	
	</div>

</body>
</html>

