<?php
// Always start this first
session_start();

//require("b_session.php");
require("b_session_declare.php");
require("b_connection.php");
require("a_head.php");

// recebe configuração flash
$s = (isset($_POST['hs'])) ? 1 : 0; // simplificado ou tradicional
$p = isset($_POST['hp']); // com ou sem pinyin de dica
$q = isset($_POST['qc']); // com ou sem pinyin de dica
$fbc = (isset($_POST['fbc'])) ? $_POST['fbc'] : 0;
?>

<script type="text/javascript">

		var r = 0; // round
		var rv = r + 1; // round visual
		var sr = 0; // score right 
		var sw = 0; // score wrong
  		var c = { // conteudo e dado
  			d: []
  		};
  		var x = { // erradas
  			y: []
  		};
  		var v = 0;
  		var j = 0;
  		var k = 0;
  		var spin = 0;
  		
		<?php

		if ($fbc > 0) {

			// SELECT DE RESULTADOS
			$sql = "SELECT c.id, c.trad, c.simp, c.pinyin, c.pt 
			FROM chineasy_cards AS c
			LEFT JOIN chineasy_category AS cat
			ON cat.id = c.cat
			WHERE c.cat = '". $fbc ."' and c.id_user = '". $varSessionUserId ."'
			ORDER BY rightscore ASC, rand()";  

		} else {

			$quantidade = ($q == '1') ? '100' : '10';

			// SELECT DE RESULTADOS
			$sql = "SELECT c.id, c.trad, c.simp, c.pinyin, c.pt 
			FROM chineasy_cards AS c
			LEFT JOIN chineasy_category AS cat
			ON cat.id = c.cat
			WHERE c.id_user = '". $varSessionUserId ."'
			ORDER BY rightscore ASC, rand()
			LIMIT " . $quantidade;                                    

		}

		$result = mysqli_query($conn, $sql); 
		$tot = 0;
		while ($l = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$setshow = ($s == 1 ? $l["simp"] : $l["trad"]);
			$setpiny = ($p == 1 ? $l["pinyin"] : '');
			$settrad = $l["trad"];
			$setsimp = $l["simp"];
			$setport = $l["pt"];
			$setpine = $l["pinyin"];
			$setcaid = $l["id"];
		?>

		var add = {
			'show': '<?=$setshow?>',
			'trad': '<?=$settrad?>',
			'simp': '<?=$setsimp?>',
			'port': '<?=$setport?>',
			'piny': '<?=$setpiny?>',
			'pine': '<?=$setpine?>',
			'caid': '<?=$setcaid?>'
		};	

		c.d.push(add);

		<?php 
		$tot++;
		} 
		?>     

		// total de cards
		var t = <?=$tot?>; 

 </script>


</head>

<body onload="start()">

		<div class="container">

  		<a href="start.php">
			<div class="bback">
	  			<div class="bback_container">
	  				<i class="fa fa-chevron-left"></i>
	  			</div>
			</div>
		</a>

  		<a href="index.php"><img src="assets/base/img/layout/logos/logo-3.png" style="margin-top: 0px;" /></a>

  		<div class="score" id="scorearea">	
			<span id="score-wrong">0</span> <i class="fa fa-times"></i> 
			&nbsp;&nbsp;
			<span id="score-right">0</span> <i class="fa fa-check"></i> 
			&nbsp;&nbsp;of&nbsp;&nbsp;
			<span id="score-total"><?=$tot?></span> <i class="fa fa-check-circle"></i> 
		</div>

		<div class="card1" id="card" onclick="show()">
  			
  			<div class="text_container" id="text">
			<span class="text1" id="content1"></span><br />
			<span class="text2" id="content2"></span>
			</div>

		</div>	

		<div class="bwrong" id="buttonwrong" onclick="set_wrong()">
  			<div class="bwrong_container">
  				<i class="fa fa-times"></i>
  			</div>
		</div>		

		<div class="bright" id="buttonright" onclick="set_right()">
  			<div class="bright_container">
  				<i class="fa fa-check"></i>
  			</div>
		</div>	

		<br clear="both" />

  	</div>

  	<script type="text/javascript">

  		function start() {
  			document.getElementById('content1').innerHTML = c.d[r].piny;	
  			document.getElementById('content2').innerHTML = c.d[r].show;	
  			document.getElementById('counting').innerHTML = rv + " of " + t;	
  		}
  		
  		function show() {
  			if (document.getElementById('card').className == 'card1') {
	  			document.getElementById('card').className ='rotate-center';
	  			setTimeout(function() { changeTo2(); }, 250);
  			} else if (document.getElementById('card').className == 'card2') {
  				document.getElementById('card').className ='rotate-center-back';
	  			setTimeout(function() { changeTo1(); }, 500);
  			} else {
  				document.getElementById('card').className ='rotate-center';
	  			setTimeout(function() { changeTo2(); }, 250);
  			}
  		}

  		function set_right() {

  			if (spin == 1) {

	  			sr += 1;

	  			<?php
	            if ($varSessionId) {
	            ?>
					saveRightScore(c.d[r].caid);
				<?php
				}
				?>

	  			// caso seja o último cartão
				if (rv == t) {

		  			if (document.getElementById('card').className == 'card1') {
			  			document.getElementById('card').className = 'rotate-center-right-from-1';
			  			setTimeout(function() { changeToEnd(); }, 350);
			  		} else {
			  			document.getElementById('card').className = 'rotate-center-right-from-2';
			  			setTimeout(function() { changeToEnd(); }, 350);
			  		}

			  	// caso não seja o último cartão ainda	  			
			  	} else {

		  			document.getElementById('score-right').innerHTML = sr;

			  		r += 1;
		  			rv += 1;
		  			
		  			if (document.getElementById('card').className == 'card1') {
			  			document.getElementById('card').className = 'rotate-left-from-1';
			  			setTimeout(function() { changeToNew(); }, 350);
			  		} else {
			  			document.getElementById('card').className = 'rotate-left-from-2';
			  			setTimeout(function() { changeToNew(); }, 350);
			  		}
		  		}

		  		spin = 0;
	  		}
  		}

  		function set_wrong() { 

			if (spin == 1) {

				// monta vetor com cards errados para review
				// aumenta contador de cards errados j
				var addx = {
						'caid': c.d[r].caid
					};	
				x.y.push(addx); 
				j += 1;

				sw += 1;

				<?php
	            if ($varSessionId) {
	            ?>
					saveWrongScore(c.d[r].caid);
				<?php
				}
				?>

				// caso seja o último cartão
				if (rv == t) {

		  			if (document.getElementById('card').className == 'card1') {
			  			document.getElementById('card').className = 'rotate-center-right-from-1';
			  			setTimeout(function() { changeToEnd(); }, 350);
			  		} else {
			  			document.getElementById('card').className = 'rotate-center-right-from-2';
			  			setTimeout(function() { changeToEnd(); }, 350);
			  		}

			  	// caso não seja o último cartão ainda	  			
			  	} else {

		  			document.getElementById('score-wrong').innerHTML = sw;

		  			r += 1;
		  			rv += 1;
		  			
		  			if (document.getElementById('card').className == 'card1') {
			  			document.getElementById('card').className = 'rotate-left-from-1';
			  			setTimeout(function() { changeToNew(); }, 350);
			  		} else {
			  			document.getElementById('card').className = 'rotate-left-from-2';
			  			setTimeout(function() { changeToNew(); }, 350);
			  		}
			  	}

			  	spin = 0;
			 }
  		}

  		function changeToNew(ddd) {
  			document.getElementById('content1').innerHTML = c.d[r].piny;
  			document.getElementById('content2').innerHTML = c.d[r].show;
  			document.getElementById('card').className ='card1';
  			document.getElementById('content1').className ='text1';
  			document.getElementById('content2').className ='text2';
  			document.getElementById('counting').innerHTML = rv + " de " + t;	

  		}

  		function rander(min, max) {
 		 	return Math.floor(Math.random() * (max - min)) + min;
		}

  		function changeToEnd() {
  			
  			// determina id de pelo menos um card errado se tiver
  			if (j > 0) {
  				k = rander(0, j);
  				v = x.y[k].caid;
  			} else {
  				k = rander(0, t);
  				v = c.d[k].caid;
  			}

  			// t = total
  			// r = right
  			// w = wrong
  			// v = rand id de card 
  			// m = mode (tran or simp)
  			window.location = "finish.php?t="+t+"&r="+sr+"&w="+sw+"&v="+v+"&m="+<?=$s?>;
  		}
		
		function changeTo2() {
			spin = 1;
  			document.getElementById('content1').innerHTML = '<span class="pyhint">' + c.d[r].pine + '</span><br />' + c.d[r].port;
  			document.getElementById('content2').innerHTML = c.d[r].trad + " (" + c.d[r].simp + ")";
  			document.getElementById('card').className ='card2';
  			document.getElementById('content1').className ='text3';
  			document.getElementById('content2').className ='text4';
  		}

  		function changeTo1() {
  			spin = 1;
  			document.getElementById('content1').innerHTML = c.d[r].piny;
  			document.getElementById('content2').innerHTML = c.d[r].show;
  			document.getElementById('card').className ='card1';
  			document.getElementById('content1').className ='text1';
  			document.getElementById('content2').className ='text2';
  		}		

  		function saveRightScore(str) {
  			
			if (str.length == 0) {
				//document.getElementById("trad").value = "";
				return;
			} else {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						//document.getElementById("trad").value = this.responseText;
					}
				};
				xmlhttp.open("GET", "ajax_right_score.php?c=" + str, true);
				xmlhttp.send();
			}
	    }

	    function saveWrongScore(str) {

			if (str.length == 0) {
				//document.getElementById("trad").value = "";
				return;
			} else {
				var xmlhttp = new XMLHttpRequest();
				xmlhttp.onreadystatechange = function() {
					if (this.readyState == 4 && this.status == 200) {
						//document.getElementById("trad").value = this.responseText;
					}
				};
				xmlhttp.open("GET", "ajax_wrong_score.php?c=" + str, true);
				xmlhttp.send();
			}
	    }

  	</script>



</body>

</html>