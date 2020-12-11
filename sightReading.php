<meta http-equiv="expires" content="Sun, 01 Jan 2014 00:00:00 GMT"/>
<meta http-equiv="pragma" content="no-cache" />

<?PHP
include "./writeSightReading.php";
?>

<html>
  <head>
  <link rel="icon" type="image/svg" href="./images/scoreIcon.svg">
    <title>Play these notes!</title>
    
    <!--/////////////////////-->
    <!-- The Verovio toolkit -->
    <!--/////////////////////-->
    <script src="https://www.verovio.org/javascript/develop/verovio-toolkit.js" type="text/javascript" ></script>
    <!--////////////////////-->
    <!-- We also use jQuery -->
    <!--////////////////////-->
    <link rel="stylesheet" href="./midiplayer.css">
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" type="text/javascript" ></script>
    <script type="text/javascript" src="http://rism-ch.org/midi-player/wildwebmidi.js"></script>
    <script type="text/javascript" src="./midiplayer.js"></script>
    <script type="text/javascript">
      ///////////////////////////
      /* Some global variables */
      ///////////////////////////
      var vrvToolkit1 = new verovio.toolkit();
      var zoom = 50;
      var pageHeight = 512* 100 / zoom ;;
      var pageWidth = 384* 100 / zoom ;;
      
      ///////////////////////////////////////////////////
      /* A function for setting options to the toolkit */
      ///////////////////////////////////////////////////
      function setOptions() {
          //////////////////////////////////////////////////////////////
          /* Adjust the height and width according to the window size */
          //////////////////////////////////////////////////////////////
          pageHeight = $(document).height() * 100 / zoom ;
          pageWidth = ($(window).width()-50) * 100 / zoom ;
          options = {
                      pageHeight: pageHeight,
                      pageWidth: pageWidth,
                      scale: zoom,
                      adjustPageHeight: true
                  };
          vrvToolkit1.setOptions(options);
      }
    </script>
    <style>
      .practiceLine{
        width:650px;
        height:111px;
      } 
      .background{
        width:800px;  
        height:360px;
      	background-size:300px 244px;
       background-repeat:no-repeat;
      }
      .inside{
        position:relative;
        left:10px;
        top:20px;
        z-index:4;
      }
      .intro {
        font-family: 'Boogaloo', cursive;
        position: relative;
        top: 65px;
        left: 119px;
        width: 560px;
        font-size: 165%;
        text-align: center;
      }
      .svg{
        position:relative;
        width:650px;
        z-index:-1;
      }
      .buttons{
        position: relative;  
        top: 62px;
        float:right;
        z-index:5;
      }
      .defaults{
        position: relative; 
        border:1px solid black; 
        top: 5%; 
        left: 15%; 
      }
    </style>
    <script type="text/javascript">
        
        var midiUpdate = function(time) {
            console.log(time);
        }
        var midiStop = function() {
            console.log("Stop");
        }
        
        function startPlaying(vtk) {
           var base64midi = vtk.renderToMIDI();
           var song = 'data:audio/midi;base64,' + base64midi;
           $("#player").midiPlayer.play(song);
        }
        
        $( document ).ready(function() {
            $("#player").midiPlayer({
                color: "red",
                onUpdate: midiUpdate,
                onStop: midiStop,
                width: 250
            });
      });
    </script>   

    </head> 

    <script type="text/javascript">
      setOptions();
      $.ajax({url: "./sightRead.mei", dataType: "text", success: function(data) {
        var svg = vrvToolkit1.renderData(data, {});
        $("#svg_output1").html(svg);                }
      });
    </script>
    
     
    <div class="background">
      <div class="inside">
        <div class="practiceLine" onclick="startPlaying(vrvToolkit1);">
        
          <div id="svg_output1" class="svg"></div>
        </div>               
      </div>
    </div> 
    
     <div id="defaults"> 
            <div id="player"></div>
            <form action="#"> 
            <table>
            <tr><td>
            <?PHP
                if(isset($_REQUEST['wn'])) $wholeNotePercentage=$_REQUEST['wn']; else $wholeNotePercentage=17;
                if(isset($_REQUEST['hn'])) $halfNotePercentage=$_REQUEST['hn']; else $halfNotePercentage=25;
                if(isset($_REQUEST['qn'])) $quarterNotePercentage=$_REQUEST['qn']; else $quarterNotePercentage=82;
                if(isset($_REQUEST['en'])) $eighthNotePercentage=$_REQUEST['en']; else $eighthNotePercentage=50;
                if(isset($_REQUEST['second'])) $secondWeight=$_REQUEST['second']; else $secondWeight=18;
                if(isset($_REQUEST['third']))$thirdWeight=$_REQUEST['third']; else $thirdWeight=59;
                if(isset($_REQUEST['fourth']))$fourthWeight=$_REQUEST['fourth']; else $fourthWeight=39;
                if(isset($_REQUEST['fifth'])) $fifthWeight=$_REQUEST['fifth']; else $fifthWeight=25;
                if(isset($_REQUEST['repeat']))$repeatWeight=$_REQUEST['repeat']; else $repeatWeight=10;
                if(isset($_REQUEST['octave']))$octaveWeight=$_REQUEST['octave']; else $octaveWeight=8;
            ?>
              <input type="range" id="wn" name="wn" min="1" max="100" value="<?PHP print $wholeNotePercentage;?>"><label for="wn">Whole Notes</label></td>
              <td><input type="range" id="repeat" name="repeat" min="1" max="100" value="<?PHP print $repeatWeight;?>"><label for="second">Repeats</label></td>
              <td><input type="range" id="fifth" name="fifth" min="1" max="100" value="<?PHP print $fifthWeight;?>"><label for="fifth">Fifths</label></td></tr>
            <tr><td>
              <input type="range" id="hn" name="hn" min="1" max="100" value="<?PHP print $halfNotePercentage;?>"><label for="hn">Halfnotes</label></td>
              <td><input type="range" id="second" name="second" min="1" max="100" value="<?PHP print $secondWeight;?>"><label for="second">Step</label></td>
              <td><input type="range" id="octave" name="octave" min="1" max="100" value="<?PHP print $octaveWeight;?>"><label for="octave">Full Octaves</label></td></tr>
            <tr><td>
              <input type="range" id="qn" name="qn" min="1" max="100" value="<?PHP print $quarterNotePercentage;?>"><label for="qn">Quarternotes</label></td>
              <td><input type="range" id="third" name="third" min="1" max="100" value="<?PHP print $thirdWeight;?>"><label for="third">Thirds</label></td>
              <td><input type="checkbox" name="title" value="<?PHP print $GLOBALS['title']."\"";    if(isset($_REQUEST['title'])) print ' checked';?>>Keep title?</td></tr>
            <tr><td>
              <input type="range" id="en" name="en" min="1" max="100" value="<?PHP print $eighthNotePercentage;?>"><label for="en">Eighthnotes</label></td>
              <td><input type="range" id="fourth" name="fourth" min="1" max="100" value="<?PHP print $fourthWeight;?>"><label for="fourth">Fourths</label></td></tr>
            </table>
               <input type="submit" value="Reload" />
            </form>
     </div>               
  </body>
</html>
