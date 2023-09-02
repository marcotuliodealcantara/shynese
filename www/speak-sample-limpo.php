<html>
<head>

<?php
// CAMINHO PARA O JSON CERTIFICADO DO GOOGLE API TEXT TO SPEECH JÁ CRIADO E CONFIGURADO NO GCP
$projectDir = __DIR__ .  '/..';
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . $projectDir . '/keys/shynese-314700-2617f68c9574.json');
?>

<script>
    // SCRIPT EM JS PARA DAR PLAY NO AUDIO SOMENTE PARA TESTE, NÃO NECESSÁRIO OBRIGATORIAMENTE
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

        <?php
        // ALGUNS CONTROLES DE ERRO SOMENTE
        //ini_set('display_errors',1);
        //ini_set('display_startup_erros',1);
        //error_reporting(E_ALL);

        // includes the autoloader for libraries installed with composer
        require '../vendor/autoload.php';

        use Google\Cloud\TextToSpeech\V1\AudioConfig;
        use Google\Cloud\TextToSpeech\V1\AudioEncoding;
        use Google\Cloud\TextToSpeech\V1\SsmlVoiceGender;
        use Google\Cloud\TextToSpeech\V1\SynthesisInput;
        use Google\Cloud\TextToSpeech\V1\TextToSpeechClient;
        use Google\Cloud\TextToSpeech\V1\VoiceSelectionParams;

        // MONTAGEM DO NOME DA PASTA E ARQUIVO
        // $qu = TIMESTAMP + IDS_CONCESSINÁRIA + IDS_EXPERIENCAI + IDS_ATIVIDADE...
        $di = "audio_files/audio_" . $qu;
        $shyhashunique = date("ymdHis");

        // CONFERE PERMISSÕES PARA LIMPEZA (CASO ESPECÍFICO DO SHYNESE)
        if (is_dir($di)) {					        
            $files = glob($di . '/*');
            foreach($files as $file) {
                //Make sure that this is a file and not a directory.
                if(is_file($file)) {
                    //Use the unlink function to delete the file.
                    unlink($file);
                }
            }
        } else {
            mkdir($di, 0777);
        }
        // FIM DE CONFERE PERMISSÕES PARA LIMPEZA (CASO ESPECÍFICO DO SHYNESE)


	    // INÍCIO DA PARTE FIXA DO SCRIPT GOOGLE TEXT TO SPEECH API    	
        $text = "Bem vindo, eu sou a Carina, sua assistente neste teste drive Volvo!";
            
        // create client object
        $client = new TextToSpeechClient();
        
        //$client->useApplicationDefaultCredentials();
        $input_text = (new SynthesisInput())
            ->setText($text);

        // note: the voice can also be specified by name
        // names of voices can be retrieved with $client->listVoices()
        $voice = (new VoiceSelectionParams())
            ->setLanguageCode('zh-CN')
            ->setSsmlGender(SsmlVoiceGender::FEMALE);

        $audioConfig = (new AudioConfig())
            ->setAudioEncoding(AudioEncoding::MP3)
            ->setSpeakingRate('0.8')
            ->setPitch("-3");

        $response = $client->synthesizeSpeech($input_text, $voice, $audioConfig);
        $audioContent = $response->getAudioContent();

        file_put_contents($di . '/' . $shyhashunique . '_output.mp3', $audioContent);
        // TESTE DE SUCESSO
        //print('Audio content written to "output.mp3"' . PHP_EOL);

        $client->close();
        // FIM DA PARTE FIXA DO SCRIPT GOOGLE TEXT TO SPEECH API
        ?>
    
        <!-- PLAYER WEB SOMENTE PARA TESTES -->
        <audio autoplay="autoplay" src='<?=$di?>/<?=$shyhashunique?>_output.mp3'></audio>
        <div class="progress_area">
            <div class='progress'>
            </div>
        </div>
        <br />
        <div class="row_audio">
                <a href="#" style="color: #000;" class="audio_replay play-pause icon-play" />REPEAT</a>
        </div>
        <!-- FIM DO PLAYER WEB PARA TESTES -->

</body>
</html>