<?PHP
class Note{
  private $acc;
  private $accName;
  private $noteName;        // The pitch in english (i.e., a, b, c, d)
  private $pitchNumber;    // The position of the note in the current scale (e.g., b is the 7th note in c major)
  private $octave;
  private $key;
  private $duration;
  
  
  public function __construct($pitchNumber, $key, $duration, $octave=4){
    $this->pitchNumber = $pitchNumber; 
    $this->key=$key;
    $this->duration=$duration;
    $this->acc = $key->getAnAx($pitchNumber);
    
    $this->octave=$octave; 
        
    if($this->acc=="s") $this->accName="#"; else if($this->acc=="f") $this->accName="b";
    
    $this->noteName=$key->getNoteName($pitchNumber);
  }
  public function getNoteName(){
    return $this->noteName;
  }
  public function getAccName(){
    return $this->accName;
  }
  public function getAcc(){
    return $this->acc;
  }
  public function getDuration(){
    return $this->duration;
  }
  public function getOctave(){
    return $this->octave;
  }
  public function getPitchNumber(){
    return $this->pitchNumber;      // This is in the current scale (i.e., b is pitchNumber 7 in C Major)
  }
  
  public function setNoteName($n){
    $this->noteName=$n;
    $this->pitchNumber=$this->key->getNotePosition($n);   
    $this->acc=$this->key->getAnAx($this->pitchNumber);
    if($this->acc=="s") $this->accName="#"; else if($this->acc=="f") $this->accName="b";    
  }
  public function setNoteNum($n){
    $this->pitchNumber=$n;
    $this->noteName=$this->key->getNoteName($n);
    $this->acc=$this->key->getAnAx($this->pitchNumber);
    if($this->acc=="s") $this->accName="#"; else if($this->acc=="f") $this->accName="b";    
  }
  public function setOctave($o){
    $this->octave=$o;
  }
  public function checkForOctave($steps){
    $whereIsC=$this->key->getNotePosition("c");    // i.e. in key of G this would return 3
    $start=$this->pitchNumber;
    $end=$start+$steps;    

    if($end==$start) return 0;
    else if($start<$end){  // Moving down the scale
        if($whereIsC<=$end && $whereIsC>$start) return 1;
        else if(($whereIsC+7)<=$end && ($whereIsC+7)>$start) return 1;
        else return 0;  
    }
    else if($start>$end){  // Moving down the scale
        if($whereIsC>$end && $whereIsC<=$start) return -1;
        else if(($whereIsC-7)>$end && ($whereIsC-7)<=$start) return -1;
        else return 0;    
    }
  }
}


class Key{
  //$keyOfG=new Key(array("g","a","b","c","d","e","f"),array("","","","","","","s"),"major");
  private $accidentalArray;
  private $tonic;
  private $mode;
  private $noteArray;
  private $keySig;
  
  public function __construct($notes, $accs, $mode){  
      $this->noteArray=$notes;  
      $this->accidentalArray = $accs;  
      $this->mode=$mode;      
      $this->tonic=$this->noteArray[0];
      $this->keySig=$this->findKeySig($accs);
      $this->relativeMinor=$this->findMinor($this->tonic);     
  }
  private function findKeySig($ax){
    $s=0;
    $f=0;
    foreach($ax as $a){
      if($a=="s") $s++;
      else if($a=="f") $f++;
    }
    if($s==0 && $f==0) return "0s";
    else if($s>0) return $s."s";
    else return $f."f";
  
  }
  private function findMinor($n){
      return $this->noteArray[5];
  }
  public function getAnAx($note){
      if($this->mode=="major") 
          return $this->accidentalArray[$note];
    else {
      $note=$note-2;
      if($note<0) $note+=7;      
      return $this->accidentalArray[$note];
    }
  }
  public function getAxName($note){
    if(!is_numeric($note)){
      $note=$this->getNotePosition($note);
    }
    if($this->mode=="major") 
      $a=$this->accidentalArray[$note];
    else {
      $note=$note-2;
      if($note<0) $note+=7;
      $a=$this->accidentalArray[$note];
    }
    if($a=="s")return "#"; else if($a=="f") return "b"; else return "";
  }
  public function getNoteName($num){
      if($this->mode=="major") 
          return $this->noteArray[$num];
      else {
        $num=$num-2;
        if($num<0) $num+=7;
        return $this->noteArray[$num];
      }
  }
  public function getKeySig(){
    return $this->keySig;
  }
  public function getTonic(){
    if($this->mode=="major") return $this->tonic;
    else return $this->relativeMinor;
  }
  public function getNotePosition($n){
    $p=array_search($n, $this->noteArray);    
    if($this->mode=="major")
      return $p; 
    else {
      $p=$p+2;
      if($p>6) $p-=7;
      return $p;
    }
  }
  public function getMode(){
    return $this->mode;
  }
}




















?>