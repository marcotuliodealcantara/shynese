<?php
// Always start this first
session_start();

//require("b_session.php");
require("b_session_declare.php");
require("b_connection.php");
require("b_head.php");

// ADD OPERAÇÃO
// VAI SER DESCONTINUADO
/*
if ((isset($_POST['insert'])) and (isset($_POST['addcat']))) {
    
    $total_to_add = sizeof($_POST['addcat']);
    $values_to_add = $_POST['addcat'];

    //print_r($_POST['addcat']);
    //echo $total_to_add . "<br /><br />";

    $sql0 = "UPDATE chineasy_category SET add_to_flashcard = '0'";
    if (mysqli_query($conn, $sql0)) {
    $warning_success = "<h4>Carregamento OK: ";
    } else {
    $warning_success = "<h4>Erro ao carregar: ";
    }

    $sql1 = "UPDATE chineasy_category SET add_to_flashcard = '1' WHERE ";
    $sql2 = "";

    $t = 0;
    while ($t < $total_to_add) {

        //echo $t . " " . $values_to_add[$t] . "<br />";

    $sql2 .= " OR id = '" . $values_to_add[$t] . "'";

    $t++;
    }

    $sql3 = substr($sql2, 3, 9999);
    $sql4 = $sql1 . $sql3;

    //echo $sql4;

    
    if (mysqli_query($conn, $sql4)) {
    $warning_success .= "Set of Flashcards updated!</h4>";
    } else {
    $warning_success .= "Error on server</h4>";
    }

} 
*/

if ($varSessionId) {

	if ((isset($_POST['changecat'])) and ($_POST['changecat'] == "1") and ($_POST['cat'] != "0")) {

		if ((isset($_POST['cat'])) and ($_POST['cat'] == "d")) {
	    
			$sql0 = "DELETE from chineasy_cards WHERE id = '".$_POST['changecard']."' LIMIT 1";
		    if (mysqli_query($conn, $sql0)) {
		    	$warning_success = "Card deleted successfully!";
		    	$warning_success_type = 1;
		    } else {
		    	$warning_success = "Error, try again!";
		    	$warning_success_type = 2;
		    }

		} else {

			$sql0 = "UPDATE chineasy_cards SET cat = '".$_POST['cat']."' WHERE id = '".$_POST['changecard']."' LIMIT 1";
		    if (mysqli_query($conn, $sql0)) {
		    	$warning_success = "Category updated successfully!";
		    	$warning_success_type = 1;
		    } else {
		    	$warning_success = "Error, try again!";
		    	$warning_success_type = 2;
		    }

		}

	}

}
?>

</head>
<body class="c-layout-header-fixed c-layout-header-mobile-fixed">
		
<?php
require("b_menu.php");
?>
	
	<!-- BEGIN: PAGE CONTAINER -->
	<div class="c-layout-page">

		<!-- BEGIN: PAGE CONTENT -->
		<!-- BEGIN: CONTENT/TILES/TILE-3 -->
		<div class="c-content-box c-size-md c-bg-white">
		<div class="c-content-tile-grid c-bs-grid-reset-space" data-auto-height="true">
			

			<?php
	        // SE CATEGORIA FOI ESCOLHIDA, MOSTRA CARDS DA CATEGORIA
	        if (isset($_GET['c'])) {

			// SELECT DE RESULTADOS
			$sql01 = "SELECT count(id) as total FROM chineasy_cards WHERE cat = '".$_GET['c']."' and id_user = '". $varSessionUserId ."'";
			$result01 = mysqli_query($conn, $sql01); 
			$t01 = mysqli_fetch_array($result01, MYSQLI_ASSOC);

			$sql02 = "SELECT titulo FROM chineasy_category WHERE id = '".$_GET['c']."'";
			$result02 = mysqli_query($conn, $sql02); 
			$t02 = mysqli_fetch_array($result02, MYSQLI_ASSOC);
	        ?>


			<div class="c-content-title-1 wow animate fadeInDown">
				<h3 class="c-font-uppercase c-center c-font-bold"><?=$t02['titulo']?> • <?=$t01['total']?> Words</h3>
				<div class="c-line-center"></div>
			</div>


			<?php
			}
			?>

		
			<div class="row wow animate fadeInUp">
			
				<div class="col-md-12">
					
					<div class="c-content-tile-1">
						<div class="row">


							<?php

							$show_results_control = 0;

					        // SE CATEGORIA FOI ESCOLHIDA, MOSTRA CARDS DA CATEGORIA
					        if (isset($_GET['c'])) {

					            // SELECT DE RESULTADOS
					            $sql = "SELECT * FROM chineasy_cards WHERE cat = '".$_GET['c']."' and id_user = '". $varSessionUserId ."' ORDER BY pt";
					            $result = mysqli_query($conn, $sql); 
					            $tot = 0;
					            $show_results_control = 1;

					        } else if (isset($_POST['s'])) {

					        	// SELECT DE RESULTADOS
					            $sql = "SELECT * FROM chineasy_cards WHERE (simp LIKE '%".$_POST['s']."%' OR trad LIKE '%".$_POST['s']."%' OR pt LIKE '%".$_POST['s']."%' OR pinyin LIKE '%".$_POST['s']."%') and id_user = '". $varSessionUserId ."' ORDER BY pt";
					            $result = mysqli_query($conn, $sql); 
					            $tot = 0;
					            $show_results_control = 1;

					        }

					        if ($show_results_control == 1) {
					            
					            while ($l = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

						            $ca = $tot % 2; // ca = cor alter							
	     							if ($ca == 0) { $cor = "c-bg-grey"; } else { $cor = "c-bg-meniun-grey"; }
						            ?>
								
										<!-- UNITY CARD -->
										<div class="col col-xs-12 col-sm-12 <?=$cor?>">
											<div class="c-tile-content c-content-overlay c-center card-padding">
												
												<!-- ondblclick="location.replace('https://www.purpleculture.net/dictionary-details/?word=' + <?=$l['trad']?>);" -->

												
												<div class="row"  onclick="toggle_content('content_<?=$l['id']?>')">
													<div class="col col-xs-0 col-sm-3 b-short-margin c-left"></div>
													<div class="col col-xs-5 col-sm-3 b-short-margin c-left">
														<h3 class="c-tile-title c-font-16 c-line-height-16 c-font-lowercase c-font-dark-grey">
															<?=substr($l['pt'], 0, 25)?><?=(((strlen($l['pt'])) > 25) ? " . . ." : "")?>
														</h3>
													</div>
													<div class="col col-xs-4 col-sm-2 b-short-margin c-right">
														<h3 class="c-tile-title c-font-18 c-line-height-16 c-font-lowercase c-font-green">
															 <i><?=$l['pinyin']?></i>
														</h3>
													</div>
													<div class="col col-xs-3 col-sm-1 b-short-margin c-right">
														<h3 class="c-tile-title c-font-24 c-line-height-16 c-font-uppercase c-font-bold c-font-dark-grey">
															<strong><?=$l['simp']?></strong>
														</h3>
													</div>
													<div class="col col-xs-0 col-sm-3 b-short-margin c-left"></div>
												</div>

												<div class="row" id="content_<?=$l['id']?>" style="display: none;">
													<div class="col col-xs-0 col-sm-3 b-short-margin c-left"></div>
													<div class="col col-xs-6 col-sm-3 b-short-margin c-left" style="padding-top: 10px;">

														
														<a target="_blank" href="https://www.purpleculture.net/dictionary-details/?word=<?=$l['trad']?>" class="c-tile-title c-font-14 c-line-height-16 c-font-lowercase c-font-gray"><i>More Info</i></a> 
														

													   	<?php
								                        if ($varSessionId) {
								                        ?>	

								                        &nbsp;|&nbsp; <a href="javascript:toggle_content('editdrop_<?=$l['id']?>')" class="c-tile-title c-font-15 c-line-height-16 c-font-lowercase c-font-gray"><i>Edit or Delete</i></a>

								                        <div id="editdrop_<?=$l['id']?>" style="display: none; margin-top: 10px;">
								                        
									                        <form method="post" action="" name="formdelchg_<?=$l['id']?>" id="formdelchg_<?=$l['id']?>" style="margin-top: 5px; margin-bottom: 5px;">
									                        <input type="hidden" name="changecat" value="1">
									                        <input type="hidden" name="changecard" value="<?=$l['id']?>">

									                        	<select name="cat" id="cat_<?=$l['id']?>" style="" onchange="delchg('formdelchg_<?=$l['id']?>')">

									                            <option value="0">Change category or delete</option>
									                              
									                            <?php
									                            // SE CATEGORIA AINDA NÃO FOI ESCOLHIDA, MOSTRA LISTA DE CATEGORIAS E SUBCATEGORIAS
									                            // SELECT DE RESULTADOS PAIS
									                            $sql1 = "SELECT titulo, id, add_to_flashcard FROM chineasy_category WHERE parent = '0' ORDER BY titulo";
									                            $result1 = mysqli_query($conn, $sql1); 
									                            while ($l1 = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {
									                            ?>

									                            <option value="<?=$l1['id']?>"><?=$l1['titulo']?></option>							

									                            <?php                                  
									                            }
									                            ?>

									                            <option value="0">- - - - - - - - -</option>
									                            <option value="d">Delete this word</option>
									                            </select>
									                        
									                        </form>

									                    </div>

														<?php
								                        }
								                        ?>

													</div>
													
													<div class="col col-xs-6 col-sm-3 b-short-margin c-right">
														<h3 class="c-tile-title c-font-24 c-line-height-16 c-font-uppercase c-font-medium-grey">
															<?=$l['trad']?>
														</h3>
													</div>
													<div class="col col-xs-0 col-sm-3 b-short-margin c-left"></div>
												</div>
												
											</div>
										</div>

								<?php
								$tot++;
								}

								if ((isset($_POST['s'])) and ($tot == 0)) {
								?>

									<!-- UNITY CARD -->
									<div class="col col-xs-12 col-sm-12">
										<div class="c-tile-content c-content-overlay c-center card-padding">
										There are no results for your search <strong><?=$_POST['s']?></strong>
										</div>
									</div>

								<?php
								}

							}
							?>

						<!-- END OF UNITY CARDS ABOVE -->
						</div>						
					</div>
				</div>

				<div class="col-md-12" style="text-align: center; padding-top: 40px;" >
				
				<a href="start.php?fbc=<?=$_GET['c']?>" class="btn c-theme-btn btn-md c-btn-uppercase c-btn-bold c-btn-square c-btn-login" style="border-radius: 90px;">Flashcard this category</a>

				</div>

			</div>
		
		</div>
		</div><!-- END: CONTENT/TILES/TILE-3 --><!-- BEGIN: PAGE CONTENT -->
	
	</div>
	<!-- END: PAGE CONTAINER -->

	<!--
	<div style="position: fixed; bottom: 0px; right: 0px; margin-right: 100px; margin-bottom: 100px;">

		<a href="javascript:;" data-toggle="modal" data-target="#addnew-form" data-dismiss="modal" class="c-link dropdown-toggle">+</a>

	</div>
	-->

<?php
require("b_foot.php");
require("b_scripts.php");
?>


<script type="text/javascript">
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
