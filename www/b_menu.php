<?php

// INSERE OPERAÇÃO
if (isset($_POST['insert']) and ($_POST['pt'] != "") and ($_POST['trad'] != "") and ($_POST['simp'] != "") and ($_POST['pinyin'] != "") and ($_POST['cat'] > "0")) {

  // SELECT DE RESULTADOS
  $sqlc = "SELECT count(id) as total FROM chineasy_cards WHERE (simp = '".$_POST['simp']."' OR trad = '".$_POST['trad']."') and id_user = '". $varSessionUserId ."'";
  $resultc = mysqli_query($conn, $sqlc); 
  $l = mysqli_fetch_array($resultc, MYSQLI_ASSOC);

  if ($l['total'] == 0) {

    $sql = "INSERT into chineasy_cards (id_user, cat, simp, trad, pinyin, pt, rightscore, wrongscore) VALUES (
    '". $varSessionUserId . "', 
    '". $_POST['cat'] . "', 
    '". $_POST['simp'] . "', 
    '". $_POST['trad'] . "', 
    '". $_POST['pinyin'] . "', 
    '". $_POST['pt'] . "',
    '0', '0')";    

    if (mysqli_query($conn, $sql)) {
        $warning_success = 'Great, one more word now!';
        $warning_success_type = 1;
        $rec_trad = '';
        $rec_simp = ''; 
        $rec_pt = ''; 
        $rec_pinyin = ''; 
        $rec_cat = $_POST['cat'];

    } else {
        
        $warning_success = 'We‘ve got an error on the server!';
        $warning_success_type = 2;
        $rec_trad = (isset($_POST['trad']) ? $_POST['trad'] : '');
        $rec_simp = (isset($_POST['simp']) ? $_POST['simp'] : ''); 
        $rec_pt = (isset($_POST['pt']) ? $_POST['pt'] : ''); 
        $rec_pinyin = (isset($_POST['pinyin']) ? $_POST['pinyin'] : ''); 
        $rec_cat = (isset($_POST['cat']) ? $_POST['cat'] : ''); 
    }

  } else {
  
    $warning_success = 'This word is already here!';
    $warning_success_type = 2;
    $rec_trad = (isset($_POST['trad']) ? $_POST['trad'] : '');
    $rec_simp = (isset($_POST['simp']) ? $_POST['simp'] : ''); 
    $rec_pt = (isset($_POST['pt']) ? $_POST['pt'] : ''); 
    $rec_pinyin = (isset($_POST['pinyin']) ? $_POST['pinyin'] : ''); 
    $rec_cat = (isset($_POST['cat']) ? $_POST['cat'] : ''); 

  }
  
} else {

  $rec_trad = (isset($_POST['trad']) ? $_POST['trad'] : '');
  $rec_simp = (isset($_POST['simp']) ? $_POST['simp'] : ''); 
  $rec_pt = (isset($_POST['pt']) ? $_POST['pt'] : ''); 
  $rec_pinyin = (isset($_POST['pinyin']) ? $_POST['pinyin'] : ''); 
  $rec_cat = (isset($_POST['cat']) ? $_POST['cat'] : ''); 

}
?>

<!-- BEGIN: LAYOUT/HEADERS/HEADER-1 -->
<!-- BEGIN: HEADER -->
<header class="c-layout-header c-layout-header-4 c-layout-header-default-mobile" data-minimize-offset="80">
		

    <?php 
    if (isset($warning_success)) { 
    ?>

      <div class="c-navbar-result">
      <div class="container-result<?=$warning_success_type?>">
      <?=$warning_success?>
      </div>
      </div>
    
    <?php 
    }
    ?>


    <div class="c-navbar">
		<div class="container">
			
			<!-- BEGIN: BRAND -->
			<div class="c-navbar-wrapper clearfix">
				<div class="c-brand c-pull-left">
					<a href="index.php" class="c-logo">
						<img src="assets/base/img/layout/logos/logo-3.png" alt="JANGO" class="c-desktop-logo">
						<img src="assets/base/img/layout/logos/logo-3.png" alt="JANGO" class="c-desktop-logo-inverse">
						<img src="assets/base/img/layout/logos/logo-3.png" alt="JANGO" class="c-mobile-logo">
					</a>
					
					<button class="c-hor-nav-toggler" type="button" data-target=".c-mega-menu">
					<span class="c-line"></span>
					<span class="c-line"></span>
					<span class="c-line"></span>
					</button>
					
					<button class="c-topbar-toggler" type="button">
						<i class="fa fa-ellipsis-v"></i>
					</button>

					<button class="c-search-toggler" type="button">
						<i class="fa fa-search"></i>
					</button>
					
					<!--<button class="c-cart-toggler" type="button">
						<i class="icon-handbag"></i> <span class="c-cart-number c-theme-bg">2</span>
					</button>-->
					
				</div>
				
        <!-- END: BRAND -->				
				<!-- BEGIN: QUICK SEARCH -->
				<form class="c-quick-search" action="vocab.php" method="post">
					<input type="text" name="s" placeholder="Search for word..." value="" class="form-control" autocomplete="off" />
					<span class="c-theme-link">&times;</span>
				</form>
				<!-- END: QUICK SEARCH -->	
				<!-- BEGIN: HOR NAV -->
				<!-- BEGIN: LAYOUT/HEADERS/MEGA-MENU -->


				<!-- BEGIN: MEGA MENU -->
				<!-- Dropdown menu toggle on mobile: c-toggler class can be applied to the link arrow or link itself depending on toggle mode -->
				<nav class="c-mega-menu c-pull-right c-mega-menu-dark c-mega-menu-dark-mobile c-fonts-uppercase c-fonts-bold">
					

					<ul class="nav navbar-nav c-theme-nav"> 
						
						<!-- <li>
						<a href="index.php" class="c-link dropdown-toggle"> <i class="fa fa-home"></i> Home<span class="c-arrow c-toggler"></span></a>
						</li> -->

            <li>
						<a href="about.php" class="c-link dropdown-toggle">About<span class="c-arrow c-toggler"></span></a>
						</li>
										
						<li>
						<a href="start.php" class="c-link dropdown-toggle">Flashcards<span class="c-arrow c-toggler"></span></a>
						</li>
						
						<li class="c-active">
						<a href="javascript:document.getElementById('simp').focus();" data-toggle="modal" data-target="#addnew-form" data-dismiss="modal" class="c-link dropdown-toggle">Add New<span class="c-arrow c-toggler"></span></a>
						</li>
						
						<li class="c-search-toggler-wrapper">
						<a href="#" class="c-btn-icon c-search-toggler"><i class="fa fa-search"></i></a>
						</li>
						
            <?php
            if ($varSessionId) {
            ?>
						
              <li>
  							<a href="logout.php" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold">Hi <?=$varSessionUserName?>, Click to Log Out</a>
  						</li>

            <?php
            } else {
            ?>

              <li>
                <a href="#" data-toggle="modal" data-target="#login-form" class="c-btn-border-opacity-04 c-btn btn-no-focus c-btn-header btn btn-sm c-btn-border-1x c-btn-dark c-btn-circle c-btn-uppercase c-btn-sbold"><i class="icon-user"></i> Sign In </a>
              </li>

            <?php
            }
            ?>

            <!-- RECURSO PRA CHAMAR O SIDEMNU
            <li class="c-search-toggler-wrapper">
              <a href="#" class="c-quick-sidebar-toggler c-btn-light"><i class="fa fa-search"></i></a>
            </li>
            -->
            						
					</ul>
				</nav>
				<!-- END: MEGA MENU --><!-- END: LAYOUT/HEADERS/MEGA-MENU -->
							
			<!-- END: HOR NAV -->		
			</div>			
			<!-- BEGIN: LAYOUT/HEADERS/QUICK-CART -->


		</div>
	</div>
</header>
<!-- END: HEADER --><!-- END: LAYOUT/HEADERS/HEADER-1 -->


<!-- BEGIN: CONTENT/USER/FORGET-PASSWORD-FORM -->
<div class="modal fade c-content-login-form" id="forget-password-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header c-no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h3 class="c-font-24 c-font-sbold">Password Recovery</h3>
                <p>To recover your password please fill in your email address</p>
                <form>
                    <div class="form-group">
                        <label for="forget-email" class="hide">Email</label>
                        <input type="email" class="form-control input-lg c-square" id="forget-email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">Submit</button>
                        <a href="javascript:;" class="c-btn-forgot" data-toggle="modal" data-target="#login-form" data-dismiss="modal">Back To Login</a>
                    </div>
                </form>
            </div>
            <div class="modal-footer c-no-border">                
                <span class="c-text-account">Don't Have An Account Yet ?</span>
                <a href="javascript:;" data-toggle="modal" data-target="#signup-form" data-dismiss="modal" class="btn c-btn-dark-1 btn c-btn-uppercase c-btn-bold c-btn-slim c-btn-border-2x c-btn-square c-btn-signup">Signup!</a>
            </div>
        </div>
    </div>
</div><!-- END: CONTENT/USER/FORGET-PASSWORD-FORM -->


<!-- BEGIN: CONTENT/USER/SIGNUP-FORM -->
<div class="modal fade c-content-login-form" id="addnew-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header c-no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                
                <?php
                if ($varSessionId) {
                ?>

                  <h3 class="c-font-24 c-font-sbold">Add New Word</h3>
                  <p>Input simplified chinese and click outside to automatically fill in all fields</p>

                  <form method="post" action="">
                  <input type="hidden" name="insert" value="1" />

                    <div style="float: right; width: 50%; text-align: right;">
                    <input type="text" name="trad" id="trad" value="<?=$rec_trad?>" class="form-control-shy-trad" style="width: 96%; height: 100px;"  />
                    </div>

                    <div style="float: left; width: 50%;">
                    <input type="text" name="simp" id="simp" value="<?=$rec_simp?>" class="form-control-shy-simp" style="width: 96%; height: 100px;" placeholder="Simp!" autocomplete="off" onblur="settradtriple(this.value)" />
                    </div>

                    <br clear="both" /><br />
                    <input type="text" name="pinyin" id="pinyin" value="<?=$rec_pinyin?>" class="form-control-shy-piny" placeholder="Pinyin">

                    <br clear="both" /><br />
                    <input type="text" name="pt" id="pt" value="<?=$rec_pt?>" class="form-control-shy" placeholder="Add Your Translation">

                    <br clear="both" /><br />

                    <select name="cat" id="cat" class="form-control-shy">
                    <option value="0">Choose Category</option>

                      <?php
                      // SE CATEGORIA AINDA NÃO FOI ESCOLHIDA, MOSTRA LISTA DE CATEGORIAS E SUBCATEGORIAS
                      // SELECT DE RESULTADOS PAIS
                      $sqlCatAdd = "SELECT titulo, id, add_to_flashcard FROM chineasy_category WHERE parent = '0' ORDER BY titulo";
                      $resultCatAdd = mysqli_query($conn, $sqlCatAdd); 
                      while ($lCatAdd = mysqli_fetch_array($resultCatAdd, MYSQLI_ASSOC)) {
                      ?>

                        <option value="<?=$lCatAdd['id']?>" <?=(($rec_cat == $lCatAdd['id']) ? 'selected="selected"' : '')?>><?=$lCatAdd['titulo']?></option>

                      <?php  
                      }
                      ?>

                    </select>
                    <br clear="both" /><br />
                    <button type="submit" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">Add</button>
                    <a href="insert.php" class="c-btn-forgot">Add Multiple</a>

                  </form>

                  <?php
                  } else {
                  ?>

                  <h3 class="c-font-24 c-font-sbold">Add New Word</h3>
                  <p>Log in to create your own words!</p>
                  <br />
                  <a href="javascript:;" data-toggle="modal" data-target="#login-form" data-dismiss="modal" class="btn c-btn-dark-1 btn c-btn-uppercase c-btn-bold c-btn-slim c-btn-border-2x c-btn-square c-btn-signup">Log In</a>
                  <br /><br />


                  <?php
                  }
                  ?>

            </div>
        </div>
    </div>
</div>
<!-- END: CONTENT/USER/SIGNUP-FORM -->


<!-- The actual snackbar -->
<div id="snackbar"></div>


<script type="text/javascript">
    var x, i, j, l, ll, selElmnt, a, b, c;
    /*look for any elements with the class "custom-select":*/
    x = document.getElementsByClassName("custom-select");
    l = x.length;
    for (i = 0; i < l; i++) {
      selElmnt = x[i].getElementsByTagName("select")[0];
      ll = selElmnt.length;
      /*for each element, create a new DIV that will act as the selected item:*/
      a = document.createElement("DIV");
      a.setAttribute("class", "select-selected");
      a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
      x[i].appendChild(a);
      /*for each element, create a new DIV that will contain the option list:*/
      b = document.createElement("DIV");
      b.setAttribute("class", "select-items select-hide");
      for (j = 1; j < ll; j++) {
        /*for each option in the original select element,
        create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function(e) {
            /*when an item is clicked, update the original select box,
            and the selected item:*/
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            for (i = 0; i < sl; i++) {
              if (s.options[i].innerHTML == this.innerHTML) {
                s.selectedIndex = i;
                h.innerHTML = this.innerHTML;
                y = this.parentNode.getElementsByClassName("same-as-selected");
                yl = y.length;
                for (k = 0; k < yl; k++) {
                  y[k].removeAttribute("class");
                }
                this.setAttribute("class", "same-as-selected");
                break;
              }
            }
            h.click();
        });
        b.appendChild(c);
      }
      x[i].appendChild(b);
      a.addEventListener("click", function(e) {
          /*when the select box is clicked, close any other select boxes,
          and open/close the current select box:*/
          e.stopPropagation();
          closeAllSelect(this);
          this.nextSibling.classList.toggle("select-hide");
          this.classList.toggle("select-arrow-active");
        });
    }
    function closeAllSelect(elmnt) {
      /*a function that will close all select boxes in the document,
      except the current select box:*/
      var x, y, i, xl, yl, arrNo = [];
      x = document.getElementsByClassName("select-items");
      y = document.getElementsByClassName("select-selected");
      xl = x.length;
      yl = y.length;
      for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
          arrNo.push(i)
        } else {
          y[i].classList.remove("select-arrow-active");
        }
      }
      for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
          x[i].classList.add("select-hide");
        }
      }
    }
    /*if the user clicks anywhere outside the select box,
    then close all select boxes:*/
    document.addEventListener("click", closeAllSelect);

    function settrad2() {
      document.getElementById("trad").value = document.getElementById("simp").value;
    }

    function settradtriple(str) {
      if (str.length == 0) {
        document.getElementById("trad").value = "";
        document.getElementById("pinyin").value = "";
        document.getElementById("pt").value = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            var restri = this.responseText; // result triple
            var resfin = restri.split("!str?"); // result final
            document.getElementById("trad").value = resfin[0];
            document.getElementById("pinyin").value = resfin[1];
            document.getElementById("pt").value = resfin[2];
            document.getElementById("pt").focus();
          }
        };
        xmlhttp.open("GET", "ajax_insert.php?s=" + str, true);
        xmlhttp.send();
      }
    }

    function settrad(str) {
      if (str.length == 0) {
        document.getElementById("trad").value = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("trad").value = this.responseText;
            document.getElementById("pt").focus();
            setpyn(str);
          }
        };
        xmlhttp.open("GET", "ajax_insert.php?s=" + str, true);
        xmlhttp.send();
      }
    }

    function setpyn(str) {
      if (str.length == 0) {
        document.getElementById("pinyin").value = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("pinyin").value = this.responseText;
            setpt(str);
          }
          
        };
        xmlhttp.open("GET", "ajax_insert_pyn.php?s=" + str, true);
        xmlhttp.send();
      }
    }

    function setpt(str) {
      if (str.length == 0) {
        document.getElementById("snackbar").value = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("pt").value = this.responseText;
            //mySnack(this.responseText);
          }
          
        };
        xmlhttp.open("GET", "ajax_insert_pt.php?s=" + str, true);
        xmlhttp.send();
      }
    }

    function mySnack(content) {
      // Get the snackbar DIV
      var x = document.getElementById("snackbar");

      // Add the "show" class to DIV
      x.className = "show";
      x.innerHTML = content;

      // After 3 seconds, remove the show class from DIV
      setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
    }

    function focusStart() {
          document.getElementById("simp").focus();      
    }

    </script>


<!-- BEGIN: CONTENT/USER/SIGNUP-FORM -->
<div class="modal fade c-content-login-form" id="signup-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header c-no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h3 class="c-font-24 c-font-sbold">Create your account!</h3>
                <p>Please fill in the form below</p>
                <form autocomplete="off" action="signup.php" method="post">
                  <input type="hidden" name="createaccount" value="1">
                    <div class="form-group">
                        <label for="signup-fullname" class="hide">Name</label>
                        <input type="text" class="form-control input-lg c-square" id="nsignup-fullname" name="fullname" autosave="false" autocomplete="false" placeholder="Name">
                    </div>
                    <div class="form-group">
                        <label for="signup-email" class="hide">Username</label>
                        <input type="text" class="form-control input-lg c-square" id="nsignup-username" name="username" autosave="none" autocomplete="none" autosave="false" autocomplete="false" placeholder="Username">
                    </div>
                    <div class="form-group">
                        <label for="signup-username" class="hide">Username</label>
                        <input type="password" class="form-control input-lg c-square" id="nsignup-password" name="password" autosave="false" autocomplete="false" placeholder="Password">
                    </div>
                    
                    <!-- <div class="form-group">
                        <label for="signup-country" class="hide">Country</label>
                        <select class="form-control input-lg c-square" id="signup-country">
                            <option value="1">Country</option>
                        </select>
                    </div> -->

                    <div class="form-group">
                        <button type="submit" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">Signup</button>
                        <a href="javascript:;" class="c-btn-forgot" data-toggle="modal" data-target="#login-form" data-dismiss="modal">Back to Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END: CONTENT/USER/SIGNUP-FORM -->


<!-- BEGIN: CONTENT/USER/LOGIN-FORM -->
<div class="modal fade c-content-login-form" id="login-form" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header c-no-border">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <h3 class="c-font-24 c-font-sbold">歡迎到SHYNESE.COM</h3>
                <p>Login to start adding your own words!</p>
                <form method="post" action="login.php">

                    <div class="form-group">
                        <input type="text" name="username" placeholder="Username" value="" class="form-control input-lg c-square" />
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" placeholder="Password" value="" class="form-control input-lg c-square" />
                    </div>                    
                    <!-- 
                    <div class="form-group">
                        <div class="c-checkbox">
                            <input type="checkbox" id="login-rememberme" class="c-check">
                            <label for="login-rememberme" class="c-font-thin c-font-17">
                                <span></span>
                                <span class="check"></span>
                                <span class="box"></span>
                                Remember Me
                            </label>
                        </div>
                    </div>
                    -->
                    <div class="form-group">
                        <button type="submit" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login">Login</button>
                        <!-- <a href="javascript:;" data-toggle="modal" data-target="#forget-password-form" data-dismiss="modal" class="c-btn-forgot">Forgot password</a> -->
                        <a href="javascript:;" data-toggle="modal" data-target="#signup-form" data-dismiss="modal" class="c-btn-forgot">Create your account</a>
                    </div>
                    
                </form>
            </div>
            <!-- 
            <div class="modal-footer c-no-border">                
                <span class="c-text-account">Don't Have An Account Yet ?</span>
                <a href="javascript:;" data-toggle="modal" data-target="#signup-form" data-dismiss="modal" class="btn c-btn-dark-1 btn c-btn-uppercase c-btn-bold c-btn-slim c-btn-border-2x c-btn-square c-btn-signup">Signup!</a>
            </div>
        	-->
        </div>
    </div>
</div><!-- END: CONTENT/USER/LOGIN-FORM -->

<!-- BEGIN: LAYOUT/SIDEBARS/QUICK-SIDEBAR -->
<nav class="c-layout-quick-sidebar">
	<div class="c-header">
		<button type="button" class="c-link c-close">
		<i class="icon-login"></i>		
		</button>
	</div>
	<div class="c-content">
		<div class="c-section">
			<h3>JANGO DEMOS</h3>
			<div class="c-settings c-demos c-bs-grid-reset-space">	
				<div class="row">
					<div class="col-md-12">
						<a href="../default/index.html" class="c-demo-container c-demo-img-lg">
							<div class="c-demo-thumb active">
								<img src="assets/base/img/content/quick-sidebar/default.jpg" class="c-demo-thumb-img"/>
							</div>
						</a>	
					</div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<a href="../corporate_1/index.html" class="c-demo-container">
							<div class="c-demo-thumb  c-thumb-left">
								<img src="assets/base/img/content/quick-sidebar/corporate_1.jpg" class="c-demo-thumb-img"/>
							</div>
						</a>	
					</div>
					<div class="col-md-6">
						<a href="../agency_1/index.html" class="c-demo-container">
							<div class="c-demo-thumb  c-thumb-right">
								<img src="assets/base/img/content/quick-sidebar/corporate_1-onepage.jpg" class="c-demo-thumb-img"/>
							</div>
						</a>	
					</div>
				</div>			
			</div>
		</div>	
		<div class="c-section">
			<h3>Theme Colors</h3>
			<div class="c-settings">

				<span class="c-color c-default c-active" data-color="default"></span>
				
				<span class="c-color c-green1" data-color="green1"></span>
				<span class="c-color c-green2" data-color="green2"></span>
				<span class="c-color c-green3" data-color="green3"></span>

				<span class="c-color c-yellow1" data-color="yellow1"></span>
				<span class="c-color c-yellow2" data-color="yellow2"></span>
				<span class="c-color c-yellow3" data-color="yellow3"></span>
				
				<span class="c-color c-red1" data-color="red1"></span>
				<span class="c-color c-red2" data-color="red2"></span>
				<span class="c-color c-red3" data-color="red3"></span>

				<span class="c-color c-purple1" data-color="purple1"></span>
				<span class="c-color c-purple2" data-color="purple2"></span>
				<span class="c-color c-purple3" data-color="purple3"></span>

				<span class="c-color c-blue1" data-color="blue1"></span>
				<span class="c-color c-blue2" data-color="blue2"></span>
				<span class="c-color c-blue3" data-color="blue3"></span>

				<span class="c-color c-brown1" data-color="brown1"></span>
				<span class="c-color c-brown2" data-color="brown2"></span>
				<span class="c-color c-brown3" data-color="brown3"></span>

				<span class="c-color c-dark1" data-color="dark1"></span>
				<span class="c-color c-dark2" data-color="dark2"></span>
				<span class="c-color c-dark3" data-color="dark3"></span>
			</div>
		</div>	
		<div class="c-section">
			<h3>Header Type</h3>
			<div class="c-settings">				
				<input type="button" class="c-setting_header-type btn btn-sm c-btn-square c-btn-border-1x c-btn-white c-btn-sbold c-btn-uppercase active" data-value="boxed" value="boxed"/>
				<input type="button" class="c-setting_header-type btn btn-sm c-btn-square c-btn-border-1x c-btn-white c-btn-sbold c-btn-uppercase" data-value="fluid" value="fluid"/>
			</div>
		</div>		
		<div class="c-section">
			<h3>Header Mode</h3>
			<div class="c-settings">			
				<input type="button" class="c-setting_header-mode btn btn-sm c-btn-square c-btn-border-1x c-btn-white c-btn-sbold c-btn-uppercase active" data-value="fixed" value="fixed"/>
				<input type="button" class="c-setting_header-mode btn btn-sm c-btn-square c-btn-border-1x c-btn-white c-btn-sbold c-btn-uppercase" data-value="static" value="static"/>
			</div>
		</div>
		<div class="c-section">
			<h3>Mega Menu Style</h3>
			<div class="c-settings">			
				<input type="button" class="c-setting_megamenu-style btn btn-sm c-btn-square c-btn-border-1x c-btn-white c-btn-sbold c-btn-uppercase active" data-value="dark" value="dark"/>
				<input type="button" class="c-setting_megamenu-style btn btn-sm c-btn-square c-btn-border-1x c-btn-white c-btn-sbold c-btn-uppercase" data-value="light" value="light"/>
			</div>
		</div>
		<div class="c-section">
			<h3>Font Style</h3>
			<div class="c-settings">			
				<input type="button" class="c-setting_font-style btn btn-sm c-btn-square c-btn-border-1x c-btn-white c-btn-sbold c-btn-uppercase active" data-value="default" value="default"/>
				<input type="button" class="c-setting_font-style btn btn-sm c-btn-square c-btn-border-1x c-btn-white c-btn-sbold c-btn-uppercase" data-value="light" value="light"/>
			</div>
		</div>
		<div class="c-section">
			<h3>Reading Style</h3>
			<div class="c-settings">	
				<a href="http://www.themehats.com/themes/jango/" class="c-setting_font-style btn btn-sm c-btn-square c-btn-border-1x c-btn-white c-btn-sbold c-btn-uppercase active">LTR</a>		
				<a href="http://www.themehats.com/themes/jango/rtl/" class="c-setting_font-style btn btn-sm c-btn-square c-btn-border-1x c-btn-white c-btn-sbold c-btn-uppercase ">RTL</a>		
			</div>
		</div>
	</div>
</nav><!-- END: LAYOUT/SIDEBARS/QUICK-SIDEBAR -->
