<?php

include "simple_html_dom.php";

$url = "http://www.nationsonline.org/oneworld/IATA_Codes/IATA_Code_";

$group = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

foreach($group as $letter){
	
	$url.=$letter.".htm";
	$html[] = file_get_html($url);
	
	foreach($html as $html_content){
		
		$IATA = $html_content->find('.tb86 tr td',0)->innertext;
		$air_port = $html_content->find('.tb86 tr td',1)->innertext;
		
		$result = $IATA." ".$air_port;
		
		echo $result.'<br>';
		
	}
	$url = "http://www.nationsonline.org/oneworld/IATA_Codes/IATA_Code_";
}

 ?>