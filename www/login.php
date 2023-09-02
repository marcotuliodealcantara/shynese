<?php
// Always start this first
session_start();
require("b_connection.php");

// INICIA OPERAÇÃO DE AUTENTICAÇÃO
if ((isset($_POST['username'])) and ($_POST['username'] != "") and (isset($_POST['password'])) and ($_POST['password'] != "")) {

    $sql = "SELECT username, password, fullname, id FROM chineasy_users WHERE username = '".$_POST['username']."' LIMIT 1";
    $res = mysqli_query($conn, $sql); 
    $val = mysqli_fetch_array($res, MYSQLI_ASSOC);
    $tot = mysqli_num_rows($res);

    // NÃO EXISTE ESTA CONTA
    if ($tot == 0) {

        $warning_success = '<h4 style="color:#D00;">There is no such account, please create your new account in the sign-up page!</h4><br />';

    } else {

        // EXISTE A CONTA
        $password_encrypt = md5($_POST['password']);

        if (($val['password'] == $password_encrypt) and ($val['username'] == $_POST['username'])) {

            $_SESSION['shynise_id'] = "VXZ6C987V6XZC9VZX9XZ87CV68V";
            $_SESSION['shynise_user_id'] = $val['id'];
            $first_name = explode(" ", $val['fullname']);
            $_SESSION['shynise_user_name'] = $first_name[0];
            header("Location: index.php");

        } else {

            $warning_success = '<h4 style="color:#D00;">Wrong password!</h4><br />';

        }

    }

} else {

    $warning_success = '<h4 style="color:#D00;">Provide username and password to go thru!</h4><br />';

}

require("b_head.php");
?>

</head>

<body>

  	<div class="container">

  		<a href="index.php"><img src="assets/base/img/layout/logos/logo-3.png" style="margin-top: 30px;" /></a>

      <br /><br />

      <h5>Login for advanced features</h5>

      <?php if (isset($warning_success)) { echo $warning_success;  } ?>
      
      <form method="post" action="">  


        <div class="row-near-bottom">
            <input type="text" name="username" class="form-control-shy" value="" style="width: 250px; height: 40px; font-size: 18px;" id="username" placeholder="Username" />
            <br /><br />
        </div>

        <div class="row-near-bottom">
            <input type="password" name="password" class="form-control-shy" value="" style="width: 250px; height: 40px; font-size: 18px;" id="password" placeholder="Password" />
            <br /><br />
        </div>

        <div class="row-near-bottom">
            <button type="submit" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">开门 • Get in!</button>
            
        </div>

      </form>

  	</div>
  
</body>


</html>