<?php
// Always start this first
session_start();

//require("b_session.php");
require("b_session_declare.php");
require("b_connection.php");
require("a_head.php");


// INSERE OPERAÇÃO
if (isset($_POST['addsentence']) and ($_POST['addsentence'] == "1") and ($_POST['sentence'] != "")) {

  // SELECT DE RESULTADOS
  $sqlc = "SELECT sentence FROM chineasy_sentences WHERE sentence = '".$_POST['sentence']."' and id_card = '". $_POST['addsentencecardid'] ."'";
  $resultc = mysqli_query($conn, $sqlc); 
  $l = mysqli_fetch_array($resultc, MYSQLI_ASSOC);

  if ($l['sentence'] == "") {

    $today = date('Y/m/d h:i:s'); 

    $sql = "INSERT into chineasy_sentences (id, id_user, id_card, sentence, used, date_created) VALUES 
          ('" . 0 . "', 
          '" . $varSessionUserId . "', 
          '" . $_POST['addsentencecardid'] . "', 
          '" . $_POST['sentence'] . "', 
          '" . 0 . "', 
          '" . $today . "')";


    if ($varSessionId) {

      if (mysqli_query($conn, $sql)) {
          $warning_success = 'Sentence added successfully!';
          $warning_success_type = 1;

      } else {
          
          $warning_success = 'We‘ve got an error on the server!';
          $warning_success_type = 2;
      }

    } else {

        $warning_success = 'You must be logged in to use this feature!';
        $warning_success_type = 2;

    }

  } else {
  
    $warning_success = 'This exactly same sentence was already added for this word!';
    $warning_success_type = 2;

  }

} else {

  $warning_success = 'You did not use this correctly!';
  $warning_success_type = 2;

}
?>

</head>

<body>

  	<div class="container">

  		<a href="index.php"><img src="assets/base/img/layout/logos/logo-3.png" style="margin-top: 25px;" /></a>

      <h2>THANKS FOR USING SHYNESE!</h2>

      <span class="score"><?=$warning_success?></span>

      <br clear="both" />

      <div class="row-center">
    		<a href="start.php">
        <div class="bstart" id="buttonstart">
      			<div class="bstart_container">
      				<i class="fa fa-thumbs-up"></i>
      			</div>
    		</div>
        </a>	
      </div>

      <br clear="both" />

  	</div>

</body>

</html>