<?PHP
function seedCorpora(){
	$GLOBALS['adjArray']=array();
	$GLOBALS['nounArray']=array();
	// $dir = "../characterDescriptions/corpora/wordLemPoS";
	$dir = "./corpora/wordLemPoS";
	$adj=0;
	$noun=0;
	$a = scandir($dir);
	$fileName=$a[rand(0,sizeof($a))];
	$fileName=$dir."/".$fileName;
	$file = fopen($fileName, "r");
	fgetcsv($file);
 
	while(!feof($file)){
		$test=fgetcsv($file,0, "\t");
		if(count($test)>2){
      if($test[2]=="jj"){
  			$GLOBALS['adjArray'][$adj]=$test[0];
  			$adj++;
  		}
  		else if($test[2]=="nn1"){
  			$GLOBALS['nounArray'][$noun]=$test[0];
  			$noun++;
  		}
    }
	}
	fclose($file);
}
function isVowel($t){
	if($t=="a" || $t=="i" || $t=="e" || $t=="o" || $t=="u") return true;
	else if($t=="A" || $t=="E" || $t=="I" || $t=="O" || $t=="U") return true;
	else return false;
}
function pickWord($isCap, $isArt, $isIs, $arr){
	//if(rand(1,3)==2) seedCorpora();
	$s=sizeof($arr)-1;
	$phrase=$arr[rand(0,$s)];

	$phrase=strtolower($phrase);
	
	if($isCap=="CAP") $phrase=ucfirst($phrase);
	if($isIs=="IS"){
		if($phrase=="they") $phrase=$phrase." Are"; 
		else $phrase=$phrase." Is"; 
	}
	if($isArt=="ART"){
		if(isVowel($phrase[0])) $art="an";
		else $art="a";
		$phrase=$art." ".$phrase;
	} 

	
	if($isCap=="CAP") $phrase=ucfirst($phrase);
	
	return $phrase;
}

function newTitle(){
    $i=rand(0,4);
    if($i==0) $title=pickWord("CAP", "ART", "", 	$GLOBALS['adjArray']).' '.pickWord("CAP", "", "", $GLOBALS['nounArray']);
    else if($i==1) $title="The ".pickWord("CAP", "", "", $GLOBALS['adjArray']).' '.pickWord("CAP", "", "", $GLOBALS['nounArray']);
    else if($i==2) $title="The ".pickWord("CAP", "", "IS", $GLOBALS['nounArray']).' Not '.pickWord("CAP", "", "", $GLOBALS['adjArray']);
    else $title=pickWord("CAP", "ART", "IS", $GLOBALS['nounArray']).' '.pickWord("CAP", "", "", $GLOBALS['adjArray']);
    
    return $title;
}
seedCorpora();

?>