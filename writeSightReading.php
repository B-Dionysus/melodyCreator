<?PHP
include "./musicClasses.php";
include "./randomTitle.php";
?>
      <?php
  
  print "<hr />";
  
function fillDurations($budget,$array, $key){

  if(isset($_REQUEST['wn'])) $wholeNotePercentage=$_REQUEST['wn']; else $wholeNotePercentage=17;
  if(isset($_REQUEST['hn'])) $halfNotePercentage=$_REQUEST['hn']; else $halfNotePercentage=25;
  if(isset($_REQUEST['qn'])) $quarterNotePercentage=$_REQUEST['qn']; else $quarterNotePercentage=82;
  if(isset($_REQUEST['en'])) $eighthNotePercentage=$_REQUEST['en']; else $eighthNotePercentage=50;


  $eighthNote=1;
  $quarterNote=2*$eighthNote;
  $halfNote=2*$quarterNote;
  $wholeNote=2*$halfNote;
  
  
  $eighthZone=$eighthNotePercentage;
  $quarterZone=$eighthNotePercentage+$quarterNotePercentage;                      // e.g., 70
  $halfZone=$eighthNotePercentage+$quarterNotePercentage+$halfNotePercentage;    // e.g., 90
  $wholeZone=$eighthNotePercentage+$quarterNotePercentage+$halfNotePercentage+$wholeNotePercentage;    // e.g., 100

  if($budget>=$wholeNote)
      $d=rand(0,$wholeZone);        // i.e., a number between 1 and 100;
  else if ($budget>=$halfNote)
      $d=rand(0,$halfZone);      // between 0 and 90
  else if($budget>=$quarterNote)
      $d=rand(0,$quarterZone);    // between 0 and 70  


  if($d>$halfZone){$budget-=$wholeNote; $newNote=new Note(0,$key,1);}   // If we rolled higher than a 90, return a whole note and decrease the budget
  else if($d>$quarterZone){$budget-=$halfNote; $newNote=new Note(0,$key,2);}
  else if($d>$eighthZone) {$budget-=$quarterNote; $newNote=new Note(0,$key,4);}
  else {
    $budget-=$eighthNote;
    $newNote=new Note(0,$key,8);
    array_push($array,$newNote);
    $budget-=$eighthNote;      // Because eighth notes always come in pairs.
    $newNote=new Note(0,$key,8);
  }
  array_push($array,$newNote);
  
  if($budget>0) $array=fillDurations($budget,$array, $key);
  return $array;
}



function chooseNotePitch($n, $clust){ 
    if(isset($_REQUEST['second'])) $secondWeight=$_REQUEST['second']; else $secondWeight=18;
    if(isset($_REQUEST['third']))$thirdWeight=$_REQUEST['third']; else $thirdWeight=59;
    if(isset($_REQUEST['fourth']))$fourthWeight=$_REQUEST['fourth']; else $fourthWeight=39;
    if(isset($_REQUEST['fifth'])) $fifthWeight=$_REQUEST['fifth']; else $fifthWeight=25;
    if(isset($_REQUEST['repeat']))$repeatWeight=$_REQUEST['repeat']; else $repeatWeight=10;
    if(isset($_REQUEST['octave']))$octaveWeight=$_REQUEST['octave']; else $octaveWeight=8;
    
    $deltaZones=array();
    
    $deltaZones[0]=$repeatWeight;   // Repeat the note
    $deltaZones[1]=$repeatWeight+$secondWeight;  // A second    
    $deltaZones[2]=$repeatWeight+$secondWeight+$thirdWeight;    
    $deltaZones[3]=$repeatWeight+$secondWeight+$thirdWeight+$fourthWeight;
    $deltaZones[4]=$repeatWeight+$secondWeight+$thirdWeight+$fourthWeight+$fifthWeight;
    $deltaZones[7]=$repeatWeight+$secondWeight+$thirdWeight+$fourthWeight+$fifthWeight+$octaveWeight;
    
    $p=rand(1,$deltaZones[7]);
    
    if($p>$deltaZones[4]) $num=7;
    else if($p>$deltaZones[3]) $num=4;
    else if($p>$deltaZones[2]) $num=3;
    else if($p>$deltaZones[1]) $num=2;
    else if($p>$deltaZones[0]) $num=1;
    else $num=0;

    if(rand(0,1)) $direction=-1; else $direction=1;
    
    if($GLOBALS['octave']>5){$direction=-1;}    // If the octave is getting high, the note should go down for sure
    else if($GLOBALS['octave']<4) $direction=1;  // Otherwise, if the octave is not too low, there's a chance it should go down

    if($clust){
      $num=rand(1,2);    // if we're in the middle of an eighthnote cluster we should stick to small steps
    }
    $num=$num*$direction; 
    $GLOBALS['octave']+=$n->checkForOctave($num);    // Brute force check to see if we've gone up or down an octave
    
    $num=$num+($n->getPitchNumber());  
     
    if($num>6){
      $num=$num-7;
    }
    else if($num<0){
      $num=$num+7;
    }  
    return $num;
}
  



function chooseKey($tonic){

  $allTheAccidentals=array(
          array("","","","","","",""),
          array("f","f","","f","f","f",""),
          array("","","s","","","","s",),
          array("f","f","","","f","",""),
          array("","s","s","","","s","s"),          
          array("","","","f","","",""),
          array("s","s","s","","s","s","s"),
          array("","","","","","","s"),
          array("f","f","","f","f","",""),
          array("","","s","","","s","s"),
          array("f","","","f","","",""),
          array("","s","s","","s","s","s"),
  );  
  $noteNameArray=      ["c", "d", "d", "e", "e", "f", "f", "g", "a", "a", "b", "b" ];
  
  $newScale=array();
  
  for($i=0;$i<7;$i++){
    $cScale=array("c","d","e","f","g","a","b");
    $t=array_search($noteNameArray[$tonic],$cScale);    // $tonic is a chromatic note (i.e., one out of 12) but for this we want the diatonic scale (1 out of 8)
    $num=$t+$i;
    if($num>6) $num-=7;
    array_push($newScale, $cScale[$num]);  
  }
  
  if(rand(0,1)) $mode="major"; else $mode="minor";
  
  $key=new Key($newScale, $allTheAccidentals[$tonic],$mode);
  return $key;
}

function writeTheFile($name){
  $debug=false;
  if(!$debug) $myfile = fopen($name, "w") or die("Unable to open ".$name);

 // 0 through 11, right? 
  $theKey=chooseKey(rand(0,11));  
  
  if(isset($_REQUEST['title'])) $GLOBALS['title']=$_REQUEST['title'];
 else $GLOBALS['title']=newTitle();
//$GLOBALS['title']="This is test #".rand(111,666);
  
  $measures=8;
  if(isset($_REQUEST['count'])) $GLOBALS['count']=$_REQUEST['count']; else $GLOBALS['count']=3+rand(0,1);    // The time signature will either be 3/4 or 4/4
  
  $currentNote=$theKey->getTonic();  
  $melody="";  
  
  $GLOBALS['octave']=4;
  $veryFirstNote=true;

  for($j=0;$j<$measures;$j++){
    $measureArray=array();
    
    // Create a full measure of notes. Set the key and the duration, but not the pitch (yet)
    $measureArray=fillDurations(($GLOBALS['count']*2),$measureArray, $theKey);    // The initial budget, in eighth notes, is twice the time signature


    $k=0;
    $beaming=false;
    $beamStart=false;
    $cluster=false;
    
    for($k=0;$k<count($measureArray);$k++){
        $currentNote=$measureArray[$k];
        if($currentNote->getDuration()==8) $thisIsAnEighthNote=true; else $thisIsAnEighthNote=false; 
    
        // If this note is an eighth note -but not the initial eighth note- then we have to pay attention (to avoid eighthnote pairs jumping octaves and such)
        if($thisIsAnEighthNote && $beamStart==false) $beamStart=true;
        else if($thisIsAnEighthNote && $beamStart==true)$cluster=true;        
        else if(!$thisIsAnEighthNote){ $cluster=false; $beamStart=false;}
        
         if($k==0){            // The first note of each measure is based on the last note of the previous measure. But! The first note of the piece is just the tonic. 
             if($veryFirstNote){
               $currentNote->setNoteName($theKey->getTonic());
               $veryFirstNote=false;
             }
             else // If this is the first note of the measure, but this isn't the first measure of the piece
               $currentNote->setNoteNum(chooseNotePitch($prevNote, $cluster));
         }
         else{
               $currentNote->setNoteNum(chooseNotePitch($prevNote, $cluster));
         }
        $EXPERIMENTAL=true;
        if($EXPERIMENTAL && !$veryFirstNote){
          $wxd=$currentNote->getDuration();
          if($wxd==2 || $wxd==1){  // Make most half notes dominant, and the rest tonic
              if(rand(0,100)>30) $currentNote->setNoteNum(4);
              else $currentNote->setNoteNum(0);
          }
        }
         $currentNote->setOctave($GLOBALS['octave']);
         $prevNote=$currentNote;
      }      
      
      
      // Print out this measure
      $melody.='<measure n="'.$j.'" ><staff n="1"><layer n="1">';        
      for($i=0;$i<count($measureArray);$i++){
      
        $currentNote=$measureArray[$i];
        if($currentNote->getDuration()==8) $thisIsAnEighthNote=true; else $thisIsAnEighthNote=false; 
    
        if($thisIsAnEighthNote && $beaming!=true){ $melody.="<beam>"; $beaming=true;}
        else if(!$thisIsAnEighthNote && $beaming){ $melody.="</beam>"; $beaming=false;}
       
       // This code made sure that the last note of the piece, whatever the duration, was always tonic. But now I'm just adding a new last note at the end, so... 
      /*if($i==(count($measureArray)-1) && $j==$measures-1){
            $currentNote->setNoteName($theKey->getTonic());  // This is the last note of the piece.
            if($currentNote->getDuration==8) $addLastNote=true;            
        }*/
        
        $melody.='<note pname="'.$currentNote->getNoteName().'" oct="'.$currentNote->getOctave().'" dur="'.$currentNote->getDuration().'" accid.ges="'.$currentNote->getAcc().'" stem.dir="up"></note>';        
      }
       if($beaming){ $melody.="</beam>"; $beaming=false;}
      $melody.='</layer></staff></measure>'."\n\n";
   } 
   if(rand(0,1))$finalDur=2; else $finalDur=1;         
   $melody.='<measure n="'.$measures.'" ><staff n="1"><layer n="1"><note pname="'.$theKey->getTonic().'" oct="'.$GLOBALS['octave'].'" dur="'.$finalDur.'" accid.ges="'.$theKey->getAnAx(0).'" stem.dir="up"></note></layer></staff></measure>';
  
  
  
  $txt ='<mei xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.music-encoding.org/ns/mei" meiversion="3.0.0">
      <meiHead>
          <fileDesc>
            <titleStmt>
                <title>'.$GLOBALS['title'].' in '.strToUpper($theKey->getTonic()).$theKey->getAxName($theKey->getTonic()).' '.$theKey->getMode().'. <titlePart type="subordinate">an aleatoric composition</titlePart> </title>                                
            </titleStmt>
          </fileDesc>
      </meiHead>
      <music>
          <body>
              <mdiv>
                  <score>
                      <scoreDef meter.count="'.$GLOBALS['count'].'" meter.unit="4" key.sig="'.$theKey->getKeySig().'" key.mode="'.$theKey->getMode().'">
                          <staffGrp symbol="brace" barthru="true" label="Piano">
                              <staffDef n="1" clef.shape="G" lines="5" clef.line="2"/>
                          </staffGrp>
                      </scoreDef>
                      <section>
                          '.$melody.'
                          <measure n="10" ><staff n="1"><layer n="1"><mRest cutout="cutout"></mRest></layer></staff></measure>
                          <measure n="10" ><staff n="1"><layer n="1"><mRest cutout="cutout"></mRest></layer></staff></measure>
                          <measure n="10" ><staff n="1"><layer n="1"><mRest cutout="cutout"></mRest></layer></staff></measure>
                          </layer></staff></measure>
                      </section>
                  </score>
              </mdiv>
          </body>
      </music>
  </mei>
  ';
   if($debug) print $txt;
   else{
      fwrite($myfile, $txt);
      fclose($myfile);
   }
  return;
}


writeTheFile("./sightRead.mei");

      chmod("./sightRead.mei", 0766);
?> 



