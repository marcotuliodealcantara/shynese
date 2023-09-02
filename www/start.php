<?php
// Always start this first
session_start();

//require("b_session.php");
require("b_session_declare.php");
require("b_connection.php");
require("a_head.php");

// OBTEM CATEGORIA PARA FLASHCARD DE CATEGORIA ESPECÍFICA
$fbc = (isset($_GET['fbc'])) ? $_GET['fbc'] : 0;
?>

</head>

<body>

  	<div class="container">

  		<a href="index.php">
      <div class="bback">
          <div class="bback_container">
            <i class="fa fa-chevron-left"></i>
          </div>
      </div>
    </a>

      <a href="index.php"><img src="assets/base/img/layout/logos/logo-3.png" style="margin-top: 0px;" /></a>

      <h2>MAKE 10 FLASHCARDS EVERYDAY</h2>

      <?php
      if (!$varSessionId) {
      ?>
        <span class="row-left" style="font-size: 16px; font-style: italic; color: #F00;">You're not logged in. Cards will not be scored.</span><br />
      <?php
      }
      ?>

      <form method="post" action="flash.php">

          <div class="row">

            <div class="row-right">
          		<label class="switch" id="hintswitch">
          		  <input type="checkbox" name="hp" value="1" />
          		  <span class="slider round"></span>
          		</label>
          		<!-- checked after type -->		
            </div>
            <div class="row-left">Use Pinyin Hints</div>

          </div>

          <br clear="both" /><br /><br />

          <div class="row">

            <div class="row-right">
              <label class="switch" id="hintswitch">
                <input type="checkbox" name="hs" value="1" />
                <span class="slider round"></span>
              </label>
              <!-- checked after type -->   
            </div>
            <div class="row-left">Simplified Chinese</div>

          </div>

          <br clear="both" /><br />

          
          <?php
          if ($fbc > 0) {
          ?>

          <input type="hidden" name="fbc" value="<?=$fbc?>">
          
          <?php
          } else {
          ?>
          <div class="row">

            <div class="row-right">
              <label class="switch" id="hintswitch">
                <input type="checkbox" name="qc" value="1" />
                <span class="slider round"></span>
              </label>
              <!-- checked after type -->   
            </div>
            <div class="row-left">Make It 100</div>

          </div>

          <br clear="both" />

          <?php
          }
          ?>

          <div class="row">
        		<!-- <a href="flash.php"> -->
                  <button class="bstart" id="buttonstart" onclick="this.form.submit()" />
          				START <i class="fa fa-chevron-right"></i> 
            <!-- </a>	-->
          </div>

      </form>

  	</div>

</body>

</html>