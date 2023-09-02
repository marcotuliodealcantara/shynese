<?php
// Always start this first
session_start();

//require("b_session.php");
require("b_session_declare.php");
require("b_connection.php");
require("b_head.php");

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

    if ($varSessionId) {

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

</head>

<body onload="focusStart()">
	<!-- abaixo foi removido da class body por ser uma página sem menu -->
	<!-- c-layout-header-fixed c-layout-header-mobile-fixed -->

	<!-- BEGIN: PAGE CONTAINER -->
	<div class="c-layout-page">

		<!-- BEGIN: PAGE CONTENT -->
		<!-- BEGIN: CONTENT/TILES/TILE-3 -->
		<div class="c-size-md c-bg-white">
		<!-- c-content-box -->
		<!-- classe acima removida do class do div acima por ser uma tela sem menu -->

		<div class="c-content-tile-grid c-bs-grid-reset-space" data-auto-height="true">

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
			
			<div class="c-content-title-1 wow animate fadeInDown" style="margin-top: 30px; margin-bottom: -20px;">

				<!-- <p class="c-center"><a href="index.php"><img src="assets/base/img/layout/logos/logo-3.png" /></a></p> -->
				<h3 class="c-font-uppercase c-center c-font-bold">Add Multiple Words</h3>
				<p class="c-center" style="margin-top: -20px; margin-bottom: 20px;">Input simplified chinese and click outside to fill in form</p>
				<div class="c-line-center"></div>

			</div>

			<div class="row wow animate fadeInUp">
			
				<div class="col-md-12">
					
					<div class="c-content-tile-1">
						<div class="row">
								
							<!-- UNITY CARD -->
							<div class="col col-xs-12 col-sm-12 <?=$cor?>">
								<div class="c-tile-content c-content-overlay c-center card-padding">
									<div class="row"  onclick="toggle_content('content_<?=$l['id']?>')">
										<div class="col col-xs-0 col-sm-3 b-short-margin c-left"></div>
										<div class="col col-xs-12 col-sm-6 b-short-margin c-right">

											<?php
											if ($varSessionId) {
											?>											

											<form method="post" action="">
											<input type="hidden" name="insert" value="1" />

											<div style="float: right; width: 50%; text-align: right;">
											<input type="text" name="trad" id="trad" value="<?=$rec_trad?>" class="form-control-shy-trad" style="width: 95%; height: 100px;"  />
											</div>

											<div style="float: left; width: 50%;">
											<input type="text" name="simp" id="simp" value="<?=$rec_simp?>" class="form-control-shy-simp" style="width: 100%; height: 100px;" placeholder="Simp!" autocomplete="off" onblur="settradtriple(this.value)" />
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
											<a href="index.php" class="c-btn-forgot" style="float: left; padding-top: 15px; margin-left: 5px;">Back to home</a>

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
										<div class="col col-xs-0 col-sm-3 b-short-margin c-left"></div>
									</div>
								</div>
							</div>

						<!-- END OF UNITY CARDS ABOVE -->
						</div>						
					</div>
				</div>

			</div>
		
		</div>
		</div><!-- END: CONTENT/TILES/TILE-3 --><!-- BEGIN: PAGE CONTENT -->
	
	</div>
	<!-- END: PAGE CONTAINER -->

<?php
require("b_foot.php");
require("b_scripts.php");
?>

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
          setTimeout(function() { focusStartDo(); }, 1000);
    }

    function focusStartDo() {
          document.getElementById("simp").focus();
    }

    function toggle_content(id) {
        
        if (document.getElementById(id).style.display == '') {
            document.getElementById(id).style.display = 'none';
        } else {
            document.getElementById(id).style.display = '';
        }

    }

    function chgcat(id) {
        
        if (document.getElementById(id).style.display == 'block') {
            document.getElementById(id).style.display = 'none';
        } else {
            document.getElementById(id).style.display = 'block';
        }

    }

    function delchg(formid) {
        
        var r = confirm("Please confirm delete or change card!");
        if (r == true) {
            document.getElementById(formid).submit();
            //location.replace("?c=" +  cat + "&d=" + id);
        } 

    }

</script>

</body>
</html>
