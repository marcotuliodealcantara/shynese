<?php
// Always start this first
session_start();

//require("b_session.php");
require("b_session_declare.php");
require("b_connection.php");
require("b_head.php");

// SELECT DE RESULTADOS
$sql1 = "SELECT count(id) as total FROM chineasy_cards WHERE id_user = '". $varSessionUserId ."'";                                    
$result1 = mysqli_query($conn, $sql1); 
$l1 = mysqli_fetch_array($result1, MYSQLI_ASSOC);
?>

</head>
<body class="c-layout-header-fixed c-layout-header-mobile-fixed">
		
<?php
require("b_menu.php");
?>

	<!-- BEGIN: PAGE CONTAINER -->
	<div class="c-layout-page">		

		<!-- BEGIN: PAGE CONTENT -->
		<div class="c-content-box c-size-md">
		<div class="container">

				<!-- BUTTON SIDEMENU OR ADD NEW FLOATING -->
				<!-- <div style="position: fixed; bottom: 50px; right: 50px; z-index: 20;">
					<div style="border-radius: 90px; background: #F00; color: #FFF; font-size: 30px; width: 80px; height: 80px; text-align: center; padding-top: 20px;">
						<ul class="nav navbar-nav c-theme-nav"> 
			            <li class="c-search-toggler-wrapper">
			              <a href="#" class="c-quick-sidebar-toggler c-btn-light"><i class="fa fa-search"></i></a>
			            </li>
			        	</ul>
					</div>
				</div>
				-->

				<div class="row" style="margin-top: -30px;">


					<?php
		            // SE CATEGORIA AINDA NÃO FOI ESCOLHIDA, MOSTRA LISTA DE CATEGORIAS E SUBCATEGORIAS
		            // SELECT DE RESULTADOS PAIS
		            $sql1 = "SELECT titulo, id, add_to_flashcard FROM chineasy_category WHERE parent = '0' ORDER BY titulo";
		            $result1 = mysqli_query($conn, $sql1); 
		            while ($l = mysqli_fetch_array($result1, MYSQLI_ASSOC)) {

		                $sqlc = "SELECT count(id) as total FROM chineasy_cards WHERE cat = '". $l['id'] ."' and id_user = '". $varSessionUserId ."'";
		                $resultc = mysqli_query($conn, $sqlc); 
		                $lc = mysqli_fetch_array($resultc, MYSQLI_ASSOC);
						
						?>

							<div class="col col-xs-6 col-sm-4 col-md-3">
								<a href="vocab.php?c=<?=$l['id']?>"><img style="border-radius: 3px;" src="assets/base/img/content/stock/c<?=$l['id']?>.jpg" alt="" width="100%"></a>
			                    <div class="cbp-l-grid-agency-title"><?=$l['titulo']?></div>
			                    <div class="cbp-l-grid-agency-desc"><?=$lc['total']?> words</div>
			                    <br />
							</div>

					<?php
					}
					?>

				</div>						        
		
		</div>
		</div>  
		<!-- END: PAGE CONTENT -->

		<!-- BEGIN: CONTENT/STATS/COUNTER-1 -->
		<div class="c-content-box c-size-md c-bg-light-grey">
			<div class="container">
				<div class="c-content-counter-1 c-opt-1">
					<div class="c-content-title-1">
						<h3 class="c-center c-font-uppercase c-font-bold">Never stop learning</h3>
						<div class="c-line-center"></div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="c-counter c-theme-border c-font-bold c-theme-font" data-counter="counterup"><?=$l1['total']?></div>
							<h4 class="c-title c-first c-font-uppercase c-font-bold">Word Count</h4>
							<a href="speak.php" class="c-content">Trying to get to 2000!</a>
						</div>
					</div>
				</div>
			</div> 
		</div>
		<!-- END: CONTENT/STATS/COUNTER-1 -->
	
	</div>
	<!-- END: PAGE CONTAINER -->

	
<?php
require("b_foot.php");
require("b_scripts.php");
?>

</body>
</html>
