<?php
// Always start this first
session_start();
require("b_connection.php");

// INSERE OPERAÇÃO
if ((isset($_POST['username'])) and (isset($_POST['fullname'])) and (isset($_POST['password'])) and ($_POST['username'] != "") and ($_POST['fullname'] != "") and ($_POST['password'] != "") and (isset($_POST['createaccount'])) and ($_POST['createaccount'] == "1")) {


  $sql = "SELECT username FROM chineasy_users WHERE username = '".$_POST['username']."' LIMIT 1";
  $res = mysqli_query($conn, $sql); 
  $tot = mysqli_num_rows($res);

  // Já existe usuário
  if ($tot > 0) {

    $warning_success = '<h4 style="color:#D00;">Username already in use, try another one.</h4><br />';
    $show_form = 1;

  }  else {
  
    $sql = "INSERT into chineasy_users (id, username, password, fullname, date_insert, status) VALUES 
            ('0', '".$_POST['username']."', '". md5($_POST['password']) ."', '".$_POST['fullname']."', '". date("Y-m-d H:i:s")."', '1')";
    
    if ($res = mysqli_query($conn, $sql)) {

        $lastid = $conn->insert_id;

        $_SESSION['shynise_id'] = "VXZ6C987V6XZC9VZX9XZ87CV68V";
        $_SESSION['shynise_user_id'] = $lastid;
        $first_name = explode(" ", $_POST['fullname']);
        $_SESSION['shynise_user_name'] = $first_name[0];

        $warning_success = '<h4 style="color:#080;">Your account was created, start adding your words!</h4>';
        $show_form = 0;

    } else {

        $warning_success = '<h4 style="color:#D00;">Something went wrong with the server, try again!</h4><br />';
        $show_form = 1;

    }
  }
} else {

    $warning_success = '<h4 style="color:#D00;">Fill in the form to go thru!</h4><br />';

    $show_form = 1;

}

require("b_head.php");
?>

</head>

<body>

  	<div class="container">

        <a href="index.php"><img src="assets/base/img/layout/logos/logo-3.png" style="margin-top: 30px;" /></a>

        <br /><br />

        <h5>Creating your account</h5>

        <?php if (isset($warning_success)) { echo $warning_success;  } ?>

        <?php
        if ($show_form == 1) {
        ?>
      
            <form method="post" action="">  

            <input type="hidden" name="createaccount" value="1">

            <div class="row-near-bottom">
            <input type="text" name="fullname" class="form-control-shy" value="" style="width: 250px; height: 40px; font-size: 18px;" id="fullname" placeholder="Name" />
            <br /><br />
            </div>

            <div class="row-near-bottom">
            <input type="text" name="username" class="form-control-shy" value="" style="width: 250px; height: 40px; font-size: 18px;" id="username" placeholder="Username" />
            <br /><br />
            </div>

            <div class="row-near-bottom">
            <input type="password" name="password" class="form-control-shy" value="" style="width: 250px; height: 40px; font-size: 18px;" id="password" placeholder="Password" />
            <br /><br />
            </div>

            <div class="row-near-bottom">
            <button type="submit" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">Get in!</button>

            </div>

            </form>

        <?php
        } else {
        ?>

            <a href="index.php" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">Get in!</a>

        <?php
        }
        ?>

  	</div>
  
</body>


</html>