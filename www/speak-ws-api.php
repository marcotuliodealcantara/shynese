<?php
//header('Cache-Control: no-store, no-cache, must-revalidate');
//header('Cache-Control: post-check=0, pre-check=0', FALSE);
//header('Pragma: no-cache');

// Always start this first
session_start();

//require("b_session.php");
require("b_session_declare.php");
require("b_connection.php");
require("a_head.php");
?>

<style type="text/css">

    .progress_area {
        position: relative;
        height: 20px;
        left: 0;
        top: 0;
        border-radius: 90px;
        margin-bottom: 40px;
        background-color: #EFEFEF;
        padding: 6px 12px 6px 12px;
    }

    .progress {
        position: relative;
        height: 8px;
        left: 0;
        top: 6px;
        border-radius: 90px;
        margin-bottom: 60px;
        background-color: #8DCC71;
    }

</style>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>

	if ('speechSynthesis' in window) {

	  var synthesis = window.speechSynthesis;

	  // Get the first `en` language voice in the list
	  var voice = synthesis.getVoices().filter(function(voice) {
	    return voice.lang === 'zn-CN';
	  })[0];

	  // Create an utterance object
	  var utterance = new SpeechSynthesisUtterance('我的家很小');

	  // Set utterance properties
	  utterance.voice = voice;
	  utterance.pitch = 1.0;
	  utterance.rate = 1.0;
	  utterance.volume = 0.8;

	  // Speak the utterance
	  synthesis.speak(utterance);

	} else {
	  console.log('Text-to-speech not supported.');
	}




    $(document).ready(function(){
        $(
          function(){
          
          var aud = $('audio')[0];
          $('.play-pause').on('click', function(){
          
          if (aud.paused) {
            aud.play();
            $('.play-pause').removeClass('icon-play');
            $('.play-pause').addClass('icon-stop');
          }
          else {
            aud.pause();
            $('.play-pause').removeClass('icon-stop');
            $('.play-pause').addClass('icon-play');
          }
          
        })
          $('.next').on('click', function(){
          aud.src = 'another audio source';
        })
          aud.ontimeupdate = function(){
            $('.progress').css('width', aud.currentTime / aud.duration * 100 + '%')
          }
        })
    });
</script>

</head>

<body>

	<script type="text/javascript">
		var synthesis = window.speechSynthesis;
		//var utterance = new SpeechSynthesisUtterance("Hello World");
		// This overrides the text "Hello World" and is uttered instead
		utterance.text = "我的家很大";
		synthesis.speak(utterance);
	</script>

  	<div class="container">

        <a href="index.php">
            <div class="bback">
                <div class="bback_container">
                    <i class="fa fa-chevron-left"></i>
                </div>
            </div>
        </a>

        <a href="index.php"><img src="assets/base/img/layout/logos/logo-3.png" style="margin-top: 0px;" /></a>

        <h2>TALKING FRIEND</h2>

        <?php
        ini_set('display_errors',1);
        ini_set('display_startup_erros',1);
        error_reporting(E_ALL);

        // includes the autoloader for libraries installed with composer
        require '../vendor/autoload.php';

        use Google\Cloud\TextToSpeech\V1\AudioConfig;
        use Google\Cloud\TextToSpeech\V1\AudioEncoding;
        use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
        use Google\Cloud\TextToSpeech\V1\SynthesisInput;
        use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
        use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;


        if (isset($_POST['talk']) == 1) {

        	$qn = (isset($_POST['turn']) ? $_POST['turn'] : 0);  // question turn - for greeting and cleaning purposes
        	$qu = (isset($varSessionUserId) ? $varSessionUserId : 0);   // user - considerando que pode ter o user demo
        	$di = "audio/audio_samples_" . $qu;

            if (isset($_POST['resp'])) {
                $re = $_POST['resp'];
                if ($re == 1) {
                    $exibe_re = "<h2>CORRECT ANSWER</h2>";
                } else if ($re == 0) {
                    $exibe_re = "<h2 style='color: #C00;'>WRONG ANSWER</h2>";
                } else {
                    $exibe_re = "";
                }
            } else {
                $exibe_re = "";
            }
                
	        // greetings
	        if ($qn == 0) {

				if (is_dir($di)) {					
					
					// garante a permissão para limpeza
		        	// chmod($di, 0777);
					
					$files = glob($di . '/*');
					foreach($files as $file) {
					    //Make sure that this is a file and not a directory.
					    if(is_file($file)) {
					        //Use the unlink function to delete the file.
					        unlink($file);
					    }
					}
					//@rmdir($di);
					//mkdir($di, 0777);

				} else {

					mkdir($di, 0777);

				}
	        	
	            $randy = rand(0, 10);
                switch ($randy) {
                    case '0':
                        $text = "好久不见";
                        break;

                    case '1':
                    case '2':
                    case '3':
                    case '4':
                        $text = "你好吗";
                        break;
                    
                    default:
                        $text = "你怎么样";
                        break;
                }   

                $ansopt1 = "很好， 谢谢";
                $ansopt2 = "不太好了";
                $resp1 = "3";
                $resp2 = "3";

	        // dialogue
	        } else {

	        	
                $randy = rand(0, 10);
                switch ($randy) {
                    case '0':
                        $text = "好的，那，告诉我下个句子有什么字: ";
                        break;
                    
                    default:
                        $text = "";
                        break;
                }	        	

	        	// SELECT DE RESULTADOS
				$sql = "SELECT s.sentence, c.simp, c.id
                from chineasy_sentences as s
                left join chineasy_cards as c
                on c.id = s.id_card
                where s.id_user = '" . $qu . "' order by rand()";
				$result = mysqli_query($conn, $sql); 
				$l = mysqli_fetch_array($result, MYSQLI_ASSOC);
				$text .= $l['sentence'];

                // SELECT DE RESULTADOS
                $sql2 = "SELECT simp
                from chineasy_cards
                where id != '" . $l['simp'] . "' order by rand()";
                $result2 = mysqli_query($conn, $sql2); 
                $l2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);

                $rand_ans = rand(0, 1);
                switch ($randy) {
                    case '0':
                        $ansopt1 = $l['simp'];
                        $ansopt2 = $l2['simp'];
                        $resp1 = "1";
                        $resp2 = "0";
                        break;
                    
                    default:
                        $ansopt2 = $l['simp'];
                        $ansopt1 = $l2['simp'];
                        $resp2 = "1";
                        $resp1 = "0";
                        break;
                }

			}

            /*
            // create client object
            $client = new TextToSpeechClient();
            $input_text = (new SynthesisInput())
                ->setText($text);

            // note: the voice can also be specified by name
            // names of voices can be retrieved with $client->listVoices()
            $voice = (new VoiceSelectionParams())
                ->setLanguageCode('zh-CN')
                ->setSsmlGender(SsmlVoiceGender::FEMALE);

            $audioConfig = (new AudioConfig())
                ->setAudioEncoding(AudioEncoding::MP3);
                //->setSpeakingRate(SpeakingRate::2);
                //->setPitch(Pitch::0);                

            $response = $client->synthesizeSpeech($input_text, $voice, $audioConfig);
            $audioContent = $response->getAudioContent();

            $shyhashunique = date("ymdHis");

            file_put_contents($di . '/' . $shyhashunique . '_output.mp3', $audioContent);
            //print('Audio content written to "output.mp3"' . PHP_EOL);

            $client->close();
            */



            ?>

                <audio autoplay="autoplay" src='<?=$di?>/<?=$shyhashunique?>_output.mp3'></audio>

                <div class="progress_area">
                  <div class='progress'>
                  </div>
                </div>

                <?=$exibe_re?>

                <div id="help" style="display: none; margin-top: 0px;"><span class="score"><?=$text?><br clear="both" /><br /></span></div>
            
                <div class="row_audio">
                    <form method="post" action="">
                    	<input type="hidden" name="talk" value="1" />
                    	<input type="hidden" name="turn" value="1" />
                        <input type="hidden" name="resp" value="<?=$resp1?>" />
                        <button class="audio_answer" id="buttonstart" onclick="this.form.submit()" /><?=$ansopt1?>
                    </form>
                </div>

                <div class="row_audio">
                    <form method="post" action="">
                        <input type="hidden" name="talk" value="1" />
                        <input type="hidden" name="turn" value="1" />
                        <input type="hidden" name="resp" value="<?=$resp2?>" />
                        <button class="audio_answer" id="buttonstart" onclick="this.form.submit()" /><?=$ansopt2?>
                    </form>
                </div>

                <br />
                <div class="row_audio">
                        <a href="#" style="color: #000;" class="audio_replay play-pause icon-play" />REPEAT</a>
                </div>

                <br />
                <div class="row_audio">
                        <a style="color: #000;" href="javascript:toggle_content('help')" class="audio_replay" />HELP</a>
                </div>



        <?php
        } else {        	
        ?>

            <span class="score">Start talking to your new revolutionary artificial intelligence buddy by clicking the button below. 
            <br /><br />
            <small>All conversation will be based in your own specific level of knowledge within the Shynese platform.</small><span /><br />

            <div class="row">
                <form method="post" action="">
                    <input type="hidden" name="talk" value="1" />
                    <button class="bstart" id="buttonstart" onclick="this.form.submit()" />LET'S TALK</i> 
                </form>
            </div>

        <?php
        }
        ?>

      </form>

  	</div>

<script type="text/javascript">
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