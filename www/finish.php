<?php
// Always start this first
session_start();

//require("b_session.php");
require("b_session_declare.php");
require("b_connection.php");
require("a_head.php");
  
      $r = (isset($_GET['v'])) ? $_GET['v'] : 0;
      $m = ((isset($_GET['m'])) and ($_GET['m'] == 1)) ? 1 : 0;      

      // SELECT DE RESULTADOS PARA REVIEW
      $sql = "SELECT simp, trad, pt, pinyin
      FROM chineasy_cards 
      WHERE id = '" . $r . "' and id_user = '" . $varSessionUserId . "'
      LIMIT 1";  
      $result = mysqli_query($conn, $sql); 
      $c = mysqli_fetch_array($result, MYSQLI_ASSOC);
      
?>

</head>

<body>

  	<div class="container">

      	<a href="index.php"><img src="assets/base/img/layout/logos/logo-3.png" style="margin-top: 25px;" /></a>

        <h2>THANKS FOR USING SHYNESE!</h2>

        <table width="100%" cellpadding="0" cellspacing="0"> 
            <tr>
              <td style="padding: 0px;" width="33%"><h1><?=$_GET['t']?></h1><span class="score">Total</span></td>
              <td style="padding: 0px;" width="33%"><h1><?=$_GET['r']?></h1><span class="score">Right</span></td>
              <td style="padding: 0px;" width="33%"><h1><?=$_GET['w']?></h1><span class="score">Wrong</span></td>
            </tr>
        </table>

        <?php
        if ($varSessionId and ($r > 0)) {
        ?>
                <br /><hr />

                <div style="border: none 0px #666; text-align: center; padding: 20px 10px 30px 10px;">
                    
                    <span class="score">Now, create a sentence using:</span><br />
                    <h1><?=(($m == 1) ? $c['simp'] : $c['trad'])?></h1>
                    <span class="score" style="color: #8DCC71; font-weight: bold;"><?=$c['pinyin']?></span> &nbsp;&nbsp;•&nbsp;&nbsp;
                    <span class="score"><?=$c['pt']?></span><br /><br />

                    <form method="post" action="sentence.php">
                    <input type="hidden" name="addsentence" value="1" />
                    <input type="hidden" name="addsentencecardid" value="<?=$r?>" />
                    <input type="text" style="width: 260px;" id="sentence" name="sentence" class="input-form-sentence" onblur="setpt(this.value)" autocomplete="off" /><br /><br />

                    <span id="sentence_pt" class="score" style="font-size: 14px;">• Input only chinese characters, not pinyin.<br />
                    • Click outsite the box to translate.</span><br />

                      <button onclick="this.form.submit();"  class="bstart" id="buttonstart" style="width: 220px;">
                            ADD SENTENCE <i class="fa fa-chevron-right"></i>
                      </button>   

                    </form>

                    <br clear="both" /><br /><br />

                </div>

        <?php
        } else {
        ?>

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

        <?php
        }
        ?>

  	</div>

    <script type="text/javascript">

    function setpt(str) {
      if (str.length == 0) {
        document.getElementById("sentence_pt").value = "";
        return;
      } else {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("sentence_pt").innerHTML = this.responseText;
          }
          
        };
        xmlhttp.open("GET", "ajax_insert_en.php?s=" + str, true);
        xmlhttp.send();
      }
    }

    function toggle_content(id) {
        
        if (document.getElementById(id).style.display == '') {
            document.getElementById(id).style.display = 'none';
        } else {
            document.getElementById(id).style.display = '';
        }

    }

    </script>

</body>

</html>