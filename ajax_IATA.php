<?php

include "simple_html_dom.php";

$url = "https://en.wikipedia.org/wiki/List_of_airports_by_IATA_code:_";

$group = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

foreach($group as $letter){
	
	$url.=$letter;
	$html[] = file_get_html($url);
	$url = "https://en.wikipedia.org/wiki/List_of_airports_by_IATA_code:_";
}
	foreach($html as $table){
		
			
		foreach($table->find('tr') as $row){
		
		$code = $row->find('td',0)->innertext;
		$air_port = $row->find('td',2)->innertext;
		$air_port = str_replace("'","",$air_port);		
		$result[$code] = "'".$air_port."',";
		
		}
			
		
	}
	
	
	echo '<pre>';
	print_r($result);
	


 ?>